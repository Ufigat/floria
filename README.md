📌 Развертывание

Перед запуском убедитесь, что у вас установлен Make. Для развертывания приложения выполните в корне проекта:

make

Я не тестировал этот процесс вне контейнера, но внутри Docker он работает.

Перейдите в папку gateway и выполните:

make <команда>


PHP

Получение уведомлений:

curl --location 'http://localhost/notifications?page=1&limit=5'

Создание уведомления:

curl --location 'http://localhost/create' \
--header 'Content-Type: application/json' \
--data-raw '{
    "to": "test08@gmail.com",
    "from": "test@gmail.com",
    "body": "123"
}'

Gateway

Получение уведомлений:

curl --location 'http://localhost:8081/notifications?page=1&limit=5'

Создание уведомления:

curl --location 'http://localhost:8081/create' \
--header 'Content-Type: application/json' \
--data-raw '{
    "to": "test08@gmail.com",
    "from": "test@gmail.com",
    "body": "123"
}'