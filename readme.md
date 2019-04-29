## create .env file

cp .env.example .env

## npm dependencies
npm install

npm run dev

## install composer dependencies
composer install

composer dump-autoload

## laravel command
php artisan key:generate

php artisan passport:install

php artisan migrate

php artisan db:seed

## start php web server
php artisan serve

## run tests
vendor/bin/phpunit