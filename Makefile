deps:
	composer up

test:
	php ./vendor/bin/phpunit -c phpunit.xml

test73:
	docker run -it --rm -v "$$PWD":/src -w /src php:7.3-cli php vendor/bin/phpunit -c phpunit.xml test/

ci: deps test

testWithCoverage:
	php ./vendor/bin/phpunit -c phpunit-coverage.xml test/
	
.PHONY: test
