up:
	docker-compose up -d
build:
	docker-compose build
stop:
	docker-compose stop
destroy:
	docker-compose down --rmi all --volumes
ps:
	docker-compose ps
api:
	docker-compose exec server bash
web:
	docker-compose exec front sh
db:
	docker-compose exec db bash
sql:
	docker-compose exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
fe_test:
	docker-compose exec server bash -c 'php artisan test --testsuite=Feature'
seed:
	docker-compose exec server bash -c 'php artisan migrate:fresh --seed'
insight:
	docker-compose exec server bash -c 'php artisan insights --fix'
