package rabbitmq_producer

import (
	"fmt"
	"github.com/streadway/amqp"
	"log"
)

type Producer struct {
	Conn *amqp.Connection
	Ch   *amqp.Channel
	Q    amqp.Queue
}

func NewProducer(amqpURL string, queueName string) (*Producer, error) {
	conn, err := amqp.Dial(amqpURL)
	if err != nil {
		return nil, fmt.Errorf("failed to connect to RabbitMQ: %w", err)
	}

	ch, err := conn.Channel()
	if err != nil {
		return nil, fmt.Errorf("failed to open a channel: %w", err)
	}

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

	return &Producer{
		Conn: conn,
		Ch:   ch,
		Q:    q,
	}, nil
}

func (p *Producer) SendMessage(message string) error {
	err := p.Ch.Publish(
		"",
		p.Q.Name,
		false,
		false,
		amqp.Publishing{
			ContentType: "text/plain",
			Body:        []byte(message),
		})
	if err != nil {
		log.Printf("Failed to publish a message: %s", err)
		return err
	}

	log.Printf("Message sent to queue: %s", message)
	return nil
}

func (p *Producer) Close() {
	err := p.Ch.Close()
	if err != nil {
		return
	}

	err = p.Conn.Close()
	if err != nil {
		return
	}
}
