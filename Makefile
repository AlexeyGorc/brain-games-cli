.PHONY: install brain-games brain-even brain-calc brain-gcd brain-progression brain-prime validate lint lint-fix analyse test test-coverage check

install:
	composer install

brain-games:
	./bin/brain-games

brain-even:
	./bin/brain-even

brain-calc:
	./bin/brain-calc

brain-gcd:
	./bin/brain-gcd

brain-progression:
	./bin/brain-progression

brain-prime:
	./bin/brain-prime

validate:
	composer validate --strict

lint:
	composer exec -- phpcs

lint-fix:
	composer exec -- phpcbf

analyse:
	composer exec -- phpstan analyse

test:
	composer exec -- phpunit

test-coverage:
	XDEBUG_MODE=coverage composer exec -- phpunit --coverage-text

check: validate lint analyse test
