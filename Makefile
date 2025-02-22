.PHONY: start-consumers stop-consumers

create-project:
	docker-compose up --build -d

install-dependencies:
	docker exec -it php composer install --no-interaction --optimize-autoloader

migrate:
	docker exec -it php php /var/www/symfony/backend/bin/console doctrine:migrations:migrate --no-interaction

# запуск консъюмеров php
start-consumers:
	@nohup docker exec -d php php /var/www/symfony/backend/bin/console rabbitmq:consume app_consumer_taker > /dev/null 2>&1 &
	@nohup docker exec -d php php /var/www/symfony/backend/bin/console rabbitmq:consume app_consumer_create > /dev/null 2>&1 &

# запуск выключение консъюмеров php
stop-consumers:
	@docker exec php pkill -f "php /var/www/symfony/backend/bin/console rabbitmq:consume" || true
