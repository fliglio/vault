deps:
	composer up

test:
	php ./vendor/bin/phpunit -c phpunit.xml

ci: deps test

.PHONY: test
