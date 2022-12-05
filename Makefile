init:
	docker-compose -f docker/docker-compose.yaml down -v
	docker-compose -f docker/docker-compose.yaml pull
	docker-compose -f docker/docker-compose.yaml up -d
	@echo "System ready!"