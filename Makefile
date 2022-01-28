install:
	docker run --rm -ti --workdir=/app -v ${PWD}:/app composer:1.9 composer install
run-example:
	docker run --rm -ti --workdir=/app/example -v ${PWD}:/app php:7.4-alpine php example.php
psalm:
	docker run --rm -ti --workdir=/app -v ${PWD}:/app php:7.4-alpine vendor/bin/psalm --no-cache --show-info=true
psalm-error:
	docker run --rm -ti --workdir=/app -v ${PWD}:/app php:7.4-alpine vendor/bin/psalm --no-cache --show-info=false
test-src:
	docker run --rm -ti --workdir=/app -v ${PWD}:/app php:7.4-alpine vendor/bin/phpunit --configuration phpunit.xml test
test-coverage:
	docker run --rm -ti --workdir=/app -e RIGHT=`id -u`:`id -g` -e XDEBUG_MODE=coverage -v ${PWD}:/app mileschou/xdebug:7.4 sh -c \
	'rm -rf test_coverage_logs; vendor/bin/phpunit --configuration phpunit.xml --coverage-html test_coverage_logs test; chown -R $${RIGHT} test_coverage_logs'
shell-php:
	docker run --rm -ti --workdir=/app -v ${PWD}:/app php:7.4-alpine sh
