# README

## SYSTEM REQUIREMENT

* DB
    - MySQL
* PHP
    - 8.3.12
* Laravel
    - 11.28.1
* Composer
    - 1.4.1
* Node
    - v16.18.1
* Npm
    - 8.19.2


## Deploy
* permission
```
chmod -R 777 bootstrap/cache
chmod -R 777 storage/logs/
chmod -R 777 storage
chmod -R 777 storage/framework
chmod -R 777 public/tmp
chmod -R 777 public/assets
```

* run
```bash
 composer install
 php artisan optimize
```

* run deploy
```bash
cp .env.example .env
php artisan key:generate
```
* config your database in .env
  find and replace database config
```bash
vi .env
```
* run database
```bash
php artisan migrate
php artisan db:seed
```

* laravel-mix
```bash
npm install
run relatime: npm run dev
```

* account
```bash
admin: /admin/hotel/search
```
