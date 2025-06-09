# Show help
help:
	@echo ""
	@echo "🛠️ Available Make Commands:"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2}'
	@echo ""

optimize: ## 本番環境向け：configとrouteをキャッシュ
	docker compose exec  php php artisan optimize

optimize-clear: ## 開発用：configとrouteのキャッシュを削除
	docker compose exec  php php artisan optimize:clear

cache: ## 本番環境向け：autoload最適化＋各種キャッシュ生成
	docker compose exec  php composer dump-autoload --optimize
	@make optimize
	docker compose exec  php php artisan event:cache
	docker compose exec  php php artisan view:cache

cache-clear: ## 開発用：キャッシュやcomposerキャッシュを全削除
	docker compose exec  php composer clear-cache
	@make optimize-clear
	docker compose exec  php php artisan event:clear
	docker compose exec  php php artisan view:clear

build:
	docker compose build
up:
	@make backend-up
	@make frontend-up
backend-up:
	docker compose up --detach
frontend-up:
	docker compose exec php npm install
	docker compose exec php npm run dev
stop:
	docker compose stop
down:
	docker compose down --remove-orphans
down-v:
	docker compose down --remove-orphans --volumes
restart:
	@make down
	@make up
destroy:
	docker compose down --rmi all --volumes --remove-orphans
tinker:
	docker compose exec php php artisan tinker
test:
	docker compose exec php php artisan test
migrate:
	docker compose exec php php artisan migrate
fresh:
	docker compose exec php php artisan migrate:fresh --seed
seed:
	docker compose exec php php artisan db:seed
