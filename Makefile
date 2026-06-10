test:
	php8.2 bin/phpunit
all_routes:
	symfony console debug:router
