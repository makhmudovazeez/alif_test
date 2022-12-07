init:
	docker-compose -f docker/docker-compose.yaml down -v
	docker-compose -f docker/docker-compose.yaml pull
	docker-compose -f docker/docker-compose.yaml up -d
	docker-compose -f docker/docker-compose.yaml exec -T php_fpm composer install --ignore-platform-reqs
	@echo "System ready!"