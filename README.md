# Restaurant-app

## Description
Restaurant-app has been created to helps restaurants cashiers to simply make orders.


## Installation
Just need to follow the standard Laravel installation

```shell
git https://github.com/mlebbeh17/restaurant-app.git
cd restaurant-app
composer install
# Setup your .env file to match your desired database
php artisan key:generate

# Purge the cache before running migrations
php artisan config:cache
php artisan config:clear

# Run migrations and seed
php artisan migrate --seed
```

### Further configuration
#### Email
Enter your mail credentials in .env for example:

````
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=yourMail@gmail.com
MAIL_PASSWORD=yourMailPassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=yourMail@gmail.com
````

#### Seeder Email
Set your seeder merchant email in the .env
````
MERCHANT_EMAIL=merchant@mail.com
````


#### Queue Connection
Set your queue connection key in .env for example:
````
QUEUE_CONNECTION=database
```
#### Run Application

```shell
# Run the queue locally
php artisan queue:work

# Run the application locally
php artisan serve
```

**PRs are welcome!**
