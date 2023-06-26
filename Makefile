up start: ## Start docker containers
	./vendor/bin/sail up -d

sl: ## Start docker containers with logs
	./vendor/bin/sail up

down stop: ## Stop docker containers
	./vendor/bin/sail stop

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
