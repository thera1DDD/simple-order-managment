cp .env .env.example

composer install 

php artisan key:generate

php artisan db:seed
