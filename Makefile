deps:
	composer up

test: run-vault
	php ./vendor/bin/phpunit -c phpunit.xml
	@killall vault


run-vault:
	@killall vault > /dev/null 2>&1 || true
	@vault server -dev -dev-root-token-id=horde >/dev/null 2>&1 &
	@sleep 1


.PHONY: test
