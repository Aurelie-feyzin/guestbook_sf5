SHELL := /bin/bash

# use tabulation not space
install:
	symfony composer install
	yarn install
	yarn encore dev
	cd spa && yarn install
	cd spa && yarn encore dev
.PHONY: install

start:
	docker-compose up -d
	symfony server:start -d
	symfony run yarn encore dev
	symfony open:local
	symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async
.PHONY: start

start_spa:
	cd spa && symfony server:start -d --passthru=index.html
	cd spa && symfony open:local
	cd spa && API_ENDPOINT=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL --dir=..` yarn encore dev
.PHONY: start_spa

build:
	symfony run -d `yarn encore dev --watch`
.PHONY: build

build_spa:
	cd spa && symfony run -d `yarn encore dev --watch`
.PHONY: build_spa

blackfire:
	./blackfire-player.phar run --endpoint=`symfony var:export SYMFONY_DEFAULT_ROUTE_URL` .blackfire.yaml --variable "webmail_url=`symfony var:export MAILER_WEB_URL 2>/dev/null`" --variable="env=dev"
.PHONY: blackfire

tests:
	symfony console doctrine:fixtures:load -n
	symfony php bin/phpunit
.PHONY: tests

stop:
	docker-compose stop
	symfony server:stop
.PHONY: stop

stop_spa:
	cd spa && symfony server:stop
.PHONY: stop_spa