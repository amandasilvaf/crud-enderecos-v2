# Laravel Skeleton

## Instalação

Clone o projeto e entre em seu diretório:

```console
$ git clone https://gitlab.com/ecode-dev/laravel-skeleton.git && cd laravel-skeleton
```

## Configuração inicial

#### 1. Gerar o arquivo .env baseado no exemplo:

```console
$ cp .env.example .env
```

#### 2. Iniciar containers do Docker:

```console
$ make up
```

#### 3. Instalar dependências da aplicação (Composer):

```console
$ make install
```

#### 3. Instalar dependências da aplicação (Yarn):

```console
$ make yarn-install
```

#### 4. Compilar arquivos do tema:

```console
$ make gulp-build
```

## Comandos Make disponíveis

Lista todos comandos Make disponíveis na aplicação:

```console
$ make help
```
