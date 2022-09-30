DC := @docker-compose

up:
	$(DC) up -d
build:
	$(DC) build
stop:
	$(DC) stop
down:
	$(DC) down --rmi all --volumes
ps:
	$(DC) ps
api:
	$(DC) exec server bash
front:
	$(DC) exec front sh
db:
	$(DC) exec db bash -c 'mysql -u $$MYSQL_USER -p$$MYSQL_PASSWORD $$MYSQL_DATABASE'
test:
	$(DC) exec server bash -c 'php artisan test --testsuite=Feature'
seed:
	$(DC) exec server bash -c 'php artisan migrate:fresh --seed'
php_cs_fixer:
	$(DC) exec -T server bash -c './tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose'
insight:
	$(DC) exec -T server bash -c 'php artisan insights --fix'
init:
	$(DC) up -d --build
	$(DC) exec -T front sh -c 'cp .env.local .env'
	$(DC) exec -T server bash -c 'cp .env.local .env'
	$(DC) exec -T server bash -c 'composer install'
	$(DC) exec -T server bash -c 'composer install --working-dir=tools/php-cs-fixer'
	$(DC) exec -T server bash -c 'chmod 755 storage/*'
	$(DC) exec -T server bash -c 'php artisan key:generate'
	@make seed
	@cp .github/hooks/pre-commit .git/hooks/pre-commit
	@chmod +x .git/hooks/pre-commit