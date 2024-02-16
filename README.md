# MX100

Birthday Message (BM) is a web system for sending birthday messages.

## Requirements

PHP >= 8.1 
https://laravel.com/docs/10.x/releases#support-policy

## Installation with Docker:

### Use Make File
1. Clone the repository using `git clone git@gitlab.com:anasark/mx100.git` command.
2. Start a Docker development environment using `make start` command.
3. Install dependencies and database structure using `make install` command.
4. (Optional) Run tests to confirm installation using `make test` command. **NOTE:** Tests may fail during first run, so repeat the command several times.

### Use Docker Command
1. Clone the repository using `git clone git@gitlab.com:anasark/mx100.git` command.
2. Start a Docker development environment using `docker compose up -d` command.
3. Copy env file using `cp .env.example .env` command.
4. Go into Container shell using `docker compose exec -ti php bash` command.
5. Install dependencies and database structure using command:
```
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan storage:link
php artisan jwt:secret
```
6. (Optional) Run tests to confirm installation using `php artisan test` command inside Container shell. **NOTE:** Tests may fail during first run, so repeat the command several times. And run this command to prepare database for testing 
```
mkdir ./database/testing
touch ./database/testing/database.sqlite
```

## Additional Docker Configuration for Apple Processor

- Must use MariaDB image instead of MySQL image.

## API Documentation
- http://localhost/api/documentation
