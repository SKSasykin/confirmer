install:
	composer install
psalm:
	${PWD}/vendor/bin/psalm --no-cache
psalm-error:
	${PWD}/vendor/bin/psalm --no-cache --show-info=false
test-src:
	${PWD}/vendor/bin/phpunit --configuration ${PWD}/phpunit.xml ${PWD}/test
test-coverage:
	rm -rf ${PWD}/test_coverage_logs
	XDEBUG_MODE=coverage ${PWD}/vendor/bin/phpunit --configuration ${PWD}/phpunit.xml --coverage-html ${PWD}/test_coverage_logs ${PWD}/test
	chown -R `id -u`:`id -g` ${PWD}/test_coverage_logs
