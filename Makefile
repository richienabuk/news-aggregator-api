up start: ## Start docker containers
	./vendor/bin/sail up -d

sl: ## Start docker containers with logs
	./vendor/bin/sail up

down stop: ## Stop docker containers
	./vendor/bin/sail stop

setup:
	docker run --rm \
		-u "$(id -u):$(id -g)" \
		-v "$(pwd):/var/www/html" \
		-w /var/www/html \
		laravelsail/php82-composer:latest \
		composer install --ignore-platform-reqs &&
	alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
	@make migrate
	@make seed

migrate: ## Setup migrations
	./vendor/bin/sail php artisan migrate

reseed: ## Reset and Seed DB
	./vendor/bin/sail php artisan migrate:fresh --seed

seed: ## Seed DB
	./vendor/bin/sail php artisan db:seed

cron:
	./vendor/bin/sail php artisan schedule:work

rebuild:
	./vendor/bin/sail build --no-cache && @make up
