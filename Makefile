.SILENT:

DOCKER_COMPOSE = docker compose
DOCKER_PHP_CONTAINER_EXEC = $(DOCKER_COMPOSE) exec php

DOCKER_PHP_EXECUTABLE_CMD = php -dmemory_limit=1G

CMD_ARTISAN = $(DOCKER_PHP_EXECUTABLE_CMD) artisan
CMD_COMPOSER = $(DOCKER_PHP_EXECUTABLE_CMD) /usr/bin/composer

start:
	$(DOCKER_COMPOSE) up -d

stop:
	$(DOCKER_COMPOSE) stop

logs:
	$(DOCKER_COMPOSE) logs -ft --tail=50

install:
ifeq (,$(wildcard ./.env))
	cp .env.example .env
endif
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_COMPOSER) install
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) key:generate
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) migrate:fresh
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) geo:seed AU --append
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) geo:seed ID --append --chunk=3000

test:
ifeq (,$(wildcard ./database/testing/database.sqlite))
	$(DOCKER_PHP_CONTAINER_EXEC) mkdir ./database/testing
	$(DOCKER_PHP_CONTAINER_EXEC) touch ./database/testing/database.sqlite
endif
	$(DOCKER_PHP_CONTAINER_EXEC) $(DOCKER_PHP_EXECUTABLE_CMD) ./vendor/bin/phpunit --bootstrap vendor/autoload.php --configuration ./phpunit.xml --no-coverage

cache:
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) config:clear
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) cache:clear
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) route:cache

reset:
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) migrate:fresh

swagger-generate:
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) l5-swagger:generate

route-list:
	$(DOCKER_PHP_CONTAINER_EXEC) $(CMD_ARTISAN) route:list

bash:
	$(DOCKER_PHP_CONTAINER_EXEC) bash
