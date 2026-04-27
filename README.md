## Requisitos

Antes de iniciar, certifique-se de ter instalado:

- PHP 8+
- Composer
- MySQL
- SQLite


## Instalação das depedências
Depois de clonar o repositório e instalar os requisitos, instale as depedências do laravel, dentro da pasta do projeto

```bash
composer install
```

## Configuração do ambiente
Para a execução do projeto, é necessário configurar o ambiente para que ele funcione. rode no terminal os seguintes comandos:

```bash
cp .env.example .env
php artisan key:generate
```

E após isso, configure o banco de dados dentro do .env, a partir das seguintes variáveis:

```bash
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

Além disso, é necessário criar o banco de dados dentro do MySQL com o nome do valor da variável 'DB_DATABASE'.

## Migrations
Execute as migrations para criar as tabelas:

```bash
php artisan migrate
```

## Iniciando a aplicação
Depois de tudo instalado e configurado, basta iniciar a aplicação.

```bash
php artisan serve
```

## Teste
Caso queira rodar os testes automatizados, basta rodar o comando:

```bash
php artisan test
```

Observação: Os testes automatizados utilizam o SQLite, para isso, é necessário a instalação, caso contrário, irá retornar erro.