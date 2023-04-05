## Blog demo application

This repo contains a demo application that we will use for this course in testing.

## Install
- Clone the repo
```bash
git clone https://github.com/spatie/testing-laravel-blog-phpunit.git && cd testing-laravel-blog-phpunit
```
- Login to MySQL monitor and create the database
```mysql
mysql -u root -p
create database testing_course_blog;
exit;
```
- Install dependencies, migrate and start the demo
```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate --seed 
php artisan serve 
```

