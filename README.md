# Birthday Message

Birthday Message (BM) is a web system for sending birthday messages.

## Requirements

PHP >= 8.1 
https://laravel.com/docs/10.x/releases#support-policy

## Installation:

### Use Make File
1. Clone the repository using `git clone git@github.com:anasark/birthday-message.git` command.
2. Go to project folder `cd birthday-message`.
3. Start a Docker development environment using `make start` command.
4. Install dependencies and database structure using `make install` command.
5. (Optional) Run tests to confirm installation using `make test` command. **NOTE:** Tests may fail during first run, so repeat the command several times.

### Manually
1. Clone the repository using `git clone git@github.com:anasark/birthday-message.git` command.
2. Go to project folder `cd birthday-message`
3. Start a Docker development environment using `docker compose up -d` command.
4. Copy env file using `cp .env.example .env` command.
5. Go into Container shell using `docker compose exec -ti php bash` command.
6. Install dependencies and database structure using command:
```
composer install
php artisan key:generate
php artisan migrate:fresh
```
7. Seed geo data using `php artisan geo:seed AU --append && php artisan geo:seed ID --append --chunk=3000` command.
   Or you can manualy insert into database, you can download the sql here https://anasabdur.com/data/geo.sql.
8. (Optional) Run tests to confirm installation using `php artisan test` command inside Container shell. **NOTE:** Tests may fail during first run, so repeat the command several times. And run this command to prepare database for testing 
```
mkdir ./database/testing
touch ./database/testing/database.sqlite
```

## Usage
### Seed user data
You can seed user data using `php artisan db:seed` command.

### Schedule
This system uses a `schedule` so that it can be sent according to the date of birth. To run schedule using `php artisan schedule:work` command. You can see a more complete document here https://laravel.com/docs/10.x/scheduling.

### Queue
To run `queue` using `php artisan queue:work` command. You can see a more complete document here https://laravel.com/docs/10.x/queues.

## API Documentation
- http://localhost/api/documentation
