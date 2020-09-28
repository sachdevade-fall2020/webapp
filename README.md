![PR Check](https://github.com/sachdevade-fall2020/webapp/workflows/Pull%20Request%20Check%20Workflow/badge.svg)

# CSYE6225 Web Application

Web application built using [Laravel](https://laravel.com/) for Network Structures and Cloud Computing (CSYE6225) course in Fall 2020.

## Prequisites
- PHP 7.2+
- PHP extensions: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- MySQL 5.6+

## Setup

1. Clone the repository.

2. Use [composer](https://getcomposer.org/) to install dependencies.

```bash
composer install
```

3. Create .env using .env.example file.

```bash
cp .env.example .env
```

4. Generate application key.

```bash
php artisan key:generate
```
5. Edit .env to configure database details.

```bash
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

6. Run migrations.

```bash
php artisan migrate
```

7. Run local server (optional).

This command will start a development server at [http://localhost:8000](http://localhost:8000)
```bash
php artisan serve
```
> **Note**: You may need to configure some permissions. Directories within the storage and the bootstrap/cache directories should be writable by your web server or application will not run

## Tests

Unit & feature tests can be executed using the following command from your project directory:
```
./vendor/bin/phpunit
```

## Author

Deepansh Sachdeva (NUID 001399788)
