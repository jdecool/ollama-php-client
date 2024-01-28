define printSection
	@printf "\033[36m\n==================================================\n\033[0m"
	@printf "\033[36m $1 \033[0m"
	@printf "\033[36m\n==================================================\n\033[0m"
endef

.PHONY: cs
cs:
	$(call printSection,CODE STYLE)
	vendor/bin/php-cs-fixer fix --dry-run --stop-on-violation --diff

.PHONY: cs-fix
cs-fix:
	vendor/bin/php-cs-fixer fix

.PHONY: cs-ci
cs-ci:
	$(call printSection,CODE STYLE)
	vendor/bin/php-cs-fixer fix --ansi --dry-run --using-cache=no --verbose

.PHONY: phpstan
phpstan:
	$(call printSection,PHPSTAN)
	vendor/bin/phpstan analyse -c phpstan.neon --ansi --no-progress --no-interaction

.PHONY: phpunit
phpunit:
	$(call printSection,PHPUNIT)
	vendor/bin/phpunit

.PHONY: phpunit-coverage
phpunit-coverage:
	$(call printSection,PHPUNIT COVERAGE)
	vendor/bin/phpunit --coverage-text

.PHONY: clean-vendor
clean-vendor:
	$(call printSection,CLEAN-VENDOR)
	rm -f composer.lock
	rm -rf vendor

.PHONY: composer-install
composer-install: vendor/composer/installed.json

vendor/composer/installed.json:
	$(call printSection,COMPOSER INSTALL)
	composer --no-interaction install --ansi --no-progress --prefer-dist
