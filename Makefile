up:
	docker compose up -d --build
	docker compose exec php composer update

down:
	docker compose down

clear:
	docker compose down -v --remove-orphans
	docker compose rm -vsf




