phpcs:
	@./vendor/bin/phpcs --standard=PSR2 src

tests:
	@./vendor/bin/phpunit tests

.PHONY: phpcs tests
