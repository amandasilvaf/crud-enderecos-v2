# Verifica se o arquivo .env existe no projeto. Caso não exista, mata a execução do script.
ENV_FILE=./.env
ifeq ("$(wildcard $(ENV_FILE))","")
$(error Arquivo .env não encontrado.)
endif

# Exporta todas variáveis do arquivo .env para variáveis de ambiente em tempo de execução, ou seja, somente durante o uso do script.
include .env
export

# Verifica qual ambiente está setado no arquivo .env.
DOCKER_COMPOSE_PREFIX=docker-compose -f docker-compose.yml

# "docker-composer exec" do serviço 'api'
API_EXEC_PREFIX=$(DOCKER_COMPOSE_PREFIX) exec -T -u 1000 laravel-base bash -c

# "docker-composer exec" do serviço 'database'
DATABASE_EXEC_PREFIX=$(DOCKER_COMPOSE_PREFIX) exec -T -u 1000 database bash -c

# ------------------------------------------------------------------------------
# Comandos Make
# ------------------------------------------------------------------------------

# Serviço database -------------------------------------------------------------

.PHONY: bash-database
bash-database:
	$(DOCKER_COMPOSE_PREFIX) exec -u 1000 database bash

# Serviço api ------------------------------------------------------------------

.PHONY: bash-api
bash-api:
	$(DOCKER_COMPOSE_PREFIX) exec -u 1000 laravel-base bash

.PHONY: clear-cache
clear-cache:
	$(API_EXEC_PREFIX) "php artisan cache:clear && php artisan config:clear"

.PHONY: composer-install
composer-install:
	$(API_EXEC_PREFIX) "composer install && composer dump-autoload"

.PHONY: yarn-install
yarn-install:
	$(API_EXEC_PREFIX) "cd development/tools && yarn"

.PHONY: gulp-build
gulp-build:
	$(API_EXEC_PREFIX) "cd development/tools && gulp build"

.PHONY: gulp-watch
gulp-watch:
	$(API_EXEC_PREFIX) "cd development/tools && gulp watch"

.PHONY: key-generate
key-generate:
ifeq ($(strip $(APP_KEY)),)
	$(API_EXEC_PREFIX) "php artisan key:generate"
else
	@echo "A chave já existe."
endif

.PHONY: migrate
migrate:
	$(API_EXEC_PREFIX) "php artisan migrate"

.PHONY: migrate-refresh
migrate-refresh:
	$(API_EXEC_PREFIX) "php artisan migrate:refresh"

.PHONY: migrate-fresh
migrate-fresh:
	$(API_EXEC_PREFIX) "php artisan migrate:fresh"

.PHONY: seed
seed:
	$(API_EXEC_PREFIX) "php artisan db:seed"

# Comandos globais/Docker  -----------------------------------------------------

.PHONY: config
config:
	$(DOCKER_COMPOSE_PREFIX) config

.PHONY: build
build:
	$(DOCKER_COMPOSE_PREFIX) build

.PHONY: up
up:
	$(DOCKER_COMPOSE_PREFIX) up -d

.PHONY: down
down:
	$(DOCKER_COMPOSE_PREFIX) down

.PHONY: down-v
down-v:
	$(DOCKER_COMPOSE_PREFIX) down -v

.PHONY: restart
restart: down up

.PHONY: recreate
recreate: down-v build up

.PHONY: bash
bash: bash-api

.PHONY: install
install: composer-install yarn-install

.PHONY: help
help:
	@echo ""
	@echo "Utilização: 'make <comando>'. Comandos disponíveis:"
	@echo ""
	@echo "  Comandos para todos os serviços:"
	@echo "    config                   Exibir variáveis e configuração do Docker."
	@echo "    build                    Executa o build em todos serviços."
	@echo "    up                       Roda todos serviços."
	@echo "    down                     Para todos serviços."
	@echo "    down-v                   Para todos serviços limpando dados do volume."
	@echo "    restart                  Reinicia todos serviços."
	@echo "    recreate                 Executa o build nos serviços apagando os dados dos volumes."
	@echo "    build                    Executa todos os builds da aplicação."
	@echo "    install                  Instala as dependencias de todos Dependency Managers da aplicação."
	@echo ""
	@echo "  Comandos para o serviço 'database':"
	@echo "    bash-database            Entra no bash da 'database'."
	@echo ""
	@echo "  Comandos para o serviço 'api':"
	@echo "    bash-api                 Entra no bash do serviço 'api'."
	@echo "    composer-install         Instala as dependências do composer na 'api'."
	@echo "    clear-cache              Limpa caches de configuração da 'api'."
	@echo "    migrate                  Executa migrations pendentes na 'api'."
	@echo "    migrate-refresh          Executa o comando 'down' e 'up' das migrations na'api'."
	@echo "    migrate-fresh            Apaga todos schemas/tabelas e executa as migrations na 'api'."
	@echo "    seed                     Executa todas as seeds da 'api'."
	@echo "    key-generate             Gera uma key, caso não haja uma."
	@echo "    jwt-secret               Gera um token JWT, caso não haja um."
	@echo ""
