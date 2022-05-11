PHP_VERSION ?= 7.4
DC_RUN_PHP = docker-compose run --rm php

########
# development Commands
########
all: update style phpstan test

install:
	$(DC_RUN_PHP) env XDEBUG_MODE=off composer install

update:
	$(DC_RUN_PHP) env XDEBUG_MODE=off composer update

test: test-unit test-integration
test-unit:
	$(DC_RUN_PHP) env XDEBUG_MODE=coverage vendor/bin/phpunit --testsuite unit --colors=always --coverage-text --testdox --coverage-clover coverage.clover --coverage-html=tests/coverage/html --log-junit=junit.xml
test-integration:
	$(DC_RUN_PHP) env XDEBUG_MODE=off vendor/bin/phpunit --testsuite integration --colors=always
phpstan:
	$(DC_RUN_PHP) env XDEBUG_MODE=off vendor/bin/phpstan analyse --memory-limit=256M

style:
	$(DC_RUN_PHP) env XDEBUG_MODE=off vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php --using-cache=no -vvv
########
# utility Commands
########

# ## printing env vars
# ## format:
# ## make print-<Variable Name>
print-%  : ; @echo $* = $($*)
