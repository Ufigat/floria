package rabbitmq_consumer

import (
	"fmt"
	"github.com/streadway/amqp"
	"log"
)

type Consumer struct {
	Conn *amqp.Connection
	Q    amqp.Queue
}

func NewConsumer(amqpURL string, queueName string, routingKey string, exchange string) (*Consumer, error) {
	conn, err := amqp.Dial(amqpURL)
	if err != nil {
		return nil, fmt.Errorf("failed to connect to RabbitMQ: %w", err)
	}

	ch, err := conn.Channel()
	if err != nil {
		return nil, fmt.Errorf("failed to open a channel: %w", err)
	}
	defer ch.Close()

	q, err := ch.QueueDeclare(
		queueName,
		false,
		false,
		false,
		false,
		nil,
	)
	if err != nil {
		return nil, fmt.Errorf("failed to declare a queue: %w", err)
	}

	err = ch.QueueBind(
		q.Name,
		routingKey,
		exchange,
		false,
		nil,
	)
	if err != nil {
		return nil, fmt.Errorf("failed to bind queue: %w", err)
	}

	return &Consumer{
		Conn: conn,
		Q:    q,
	}, nil
}

func (c *Consumer) ConsumeMessages(callback func(string)) error {
	ch, err := c.Conn.Channel()
	if err != nil {
		return fmt.Errorf("failed to create a channel: %w", err)
	}

	msgs, err := ch.Consume(
		c.Q.Name,
		"",
		true,
		false,
		false,
		false,
		nil,
	)
	if err != nil {
		_ = ch.Close()
		return fmt.Errorf("failed to start consuming: %w", err)
	}

	log.Printf("Started consuming from queue: %s", c.Q.Name)

	for msg := range msgs {
		callback(string(msg.Body))
	}

	_ = ch.Close()
	return nil
}

func (c *Consumer) Close() {
	if err := c.Conn.Close(); err != nil {
		log.Printf("Error closing connection: %s", err)
	}
}
