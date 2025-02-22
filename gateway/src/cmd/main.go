package main

import (
	"encoding/json"
	"fmt"
	"gateway/src/models"
	"gateway/src/rabbitmq_consumer"
	"gateway/src/rabbitmq_producer"
	"github.com/labstack/echo/v4"
	"github.com/mailru/easyjson"
	"io"
	"log"
	"net/http"
	"strconv"
	"time"
)

var createProducer *rabbitmq_producer.Producer
var readProducer *rabbitmq_producer.Producer
var consumer *rabbitmq_consumer.Consumer

func createNotificationHandler(c echo.Context) error {
	var reqData models.NotificationRequest

	body, err := io.ReadAll(c.Request().Body)
	if err != nil {
		return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to read request body"})
	}

	if err := easyjson.Unmarshal(body, &reqData); err != nil {
		return c.JSON(http.StatusBadRequest, map[string]string{"error": "Invalid JSON"})
	}

	message, err := easyjson.Marshal(&reqData)
	if err != nil {
		log.Printf("Error marshaling to JSON: %v", err)
		return c.JSON(http.StatusInternalServerError, map[string]string{"error": "Failed to marshal message"})
	}

	err = sendToQueue(string(message), "create")
	if err != nil {
		return c.String(http.StatusInternalServerError, "Failed to send message to RabbitMQ")
	}

	return c.String(http.StatusOK, "Сообщение отправлено в RabbitMQ")
}

func notificationsHandler(c echo.Context) error {
	page := c.QueryParam("page")
	limit := c.QueryParam("limit")

	messageData := map[string]string{
		"page":  page,
		"limit": limit,
	}

	messageJSON, err := json.Marshal(messageData)
	if err != nil {
		return c.String(http.StatusInternalServerError, "Failed to marshal JSON")
	}

	err = sendToQueue(string(messageJSON), "take")
	if err != nil {
		return c.String(http.StatusInternalServerError, "Failed to send message to RabbitMQ")
	}

	responseChannel := make(chan models.NotificationResponsePagination, 1)

	ch, err := consumer.Conn.Channel()
	if err != nil {
		return c.String(http.StatusInternalServerError, "Failed to create a new channel")
	}
	defer ch.Close()

	consumerTag := "consumer-" + strconv.FormatInt(time.Now().UnixNano(), 10)

	msgs, err := ch.Consume(
		consumer.Q.Name,
		consumerTag,
		true,
		false,
		false,
		false,
		nil,
	)
	if err != nil {
		return c.String(http.StatusInternalServerError, "Failed to register consumer")
	}

	go func() {
		for msg := range msgs {
			var response models.NotificationResponsePagination
			if err := json.Unmarshal(msg.Body, &response); err != nil {
				log.Printf("Failed to unmarshal message: %v", err)
				continue
			}

			responseChannel <- response

			if err := ch.Cancel(consumerTag, false); err != nil {
				log.Printf("Failed to cancel consumer: %v", err)
			}
			break
		}
	}()

	select {
	case receivedMessage := <-responseChannel:
		return c.JSON(http.StatusOK, receivedMessage)
	case <-time.After(10 * time.Second):
		return c.String(http.StatusRequestTimeout, "Timeout waiting for message")
	}
}

func sendToQueue(message, queue string) error {
	var producer *rabbitmq_producer.Producer

	if queue == "create" {
		producer = createProducer
	} else if queue == "take" {
		producer = readProducer
	} else {
		return fmt.Errorf("invalid queue: %s", queue)
	}

	err := producer.SendMessage(message)
	if err != nil {
		log.Printf("Failed to send message: %s", err)
		return err
	}

	log.Printf("Message sent: %s", message)
	return nil
}

func main() {

	var err error
	createProducer, err = rabbitmq_producer.NewProducer("amqp://guest:guest@localhost:5672/", "create")
	if err != nil {
		log.Fatalf("Failed to create producer: %s", err)
	}
	defer createProducer.Close()

	readProducer, err = rabbitmq_producer.NewProducer("amqp://guest:guest@localhost:5672/", "take")
	if err != nil {
		log.Fatalf("Failed to create producer: %s", err)
	}
	defer readProducer.Close()

	consumer, err = rabbitmq_consumer.NewConsumer(
		"amqp://guest:guest@localhost:5672/",
		"read",
		"read",
		"messages",
	)
	if err != nil {
		log.Fatalf("Failed to create consumer: %s", err)
	}

	e := echo.New()
	e.POST("/create", createNotificationHandler)
	e.GET("/notifications", notificationsHandler)

	e.Logger.Fatal(e.Start(":8081"))
}
