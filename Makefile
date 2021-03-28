DC=docker-compose
RUN=$(DC) run --service-ports --rm app

dev:
dev: build up install serve

bash:
bash: go_bash

test:
test: build up install test

stop:
	$(DC) kill

build:
	$(DC) build

up:
	$(DC) up -d

go_bash:
	@$(RUN) bash

install:
	@$(RUN) composer install
	@$(RUN) php bin/console doctrine:database:create --if-not-exists
	@$(RUN) php bin/console doctrine:schema:update --force
	@$(RUN) php bin/console app:install
	@$(RUN) php bin/console cache:clear

test:
	@$(RUN) composer run-script tests

serve:
	@$(RUN) /usr/bin/supervisord
