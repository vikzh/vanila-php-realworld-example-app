run:
	php -S localhost:8000 -t public/
lint:
	composer run-script phpcs
