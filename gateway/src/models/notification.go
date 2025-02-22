package models

type NotificationRequest struct {
	To   string `json:"to"`
	From string `json:"from"`
	Body string `json:"body"`
}

type NotificationResponsePagination struct {
	NotificationResponse []NotificationResponse `json:"notifications"`
	Page                 string                 `json:"page"`
	Count                string                 `json:"limit"`
}

type NotificationResponse struct {
	To   string `json:"recipientEmail"`
	From string `json:"senderEmail"`
	Body string `json:"message"`
}
