## Requeriments
- mysql >= 5.7
- PHP >= 7.2.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

# Installation
~~~
composer install
cp .env.example .env
php artisan key:generate
.env file configure mysql server parameters
create MySQL database square1 or copy this sentence
CREATE DATABASE IF NOT EXISTS `square1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
php artisan migrate
~~~

# Usage

Use `/config/scrap.php` file to config categories filter to find items for each category.

Remeber that for each change use `php artisan config:cache`

For scraping use `php artisan scrap` and check database and `public/img` directory.
> Be patient in my machine has taken 00:11:17 to scrap

## Task Scheduling
you only need to add the following Cron entry to your server.
~~~
* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
~~~
This Cron will call the Laravel command scheduler every minute.



# TODO
- [X] Create empty Laravel project.
- [X] Create Schema project.
- [X] Register and login.
- [x] first scraping version.
- [X] Add command scrape.
- [X] Add scrape cron every day.
- [ ] Only scraping new items. (I have not found any 'product_id' in page)
- [ ] Add command scrape:fresh.
- [ ] Add command scrape:refresh.
- [ ] create controller whislisht.
- [ ] Add UI with Blade.
