# Limg
## An image hosting service powered by Laravel
  
<img src="https://i.imgur.com/8jAfnaz.png" width=500 align="center">
  

<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>

### Requirement
- [**PHP**](https://php.net) 5.6.4+ (**7.0** preferred)
- PHP Extensions: openssl, mcrypt and mbstring, phpredis
- Database server: [MySQL](https://www.mysql.com) or [**MariaDB**](https://mariadb.org)
- [Redis](http://redis.io) Server
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org/) with npm

### Installation
* clone the repository: `git clone https://git.latable.dev/Havens/Limg Limg`
* create a database
* create configuration env file `.env` refer to `.env.example`
* install: `composer install --no-dev`
* setup database tables: `php artisan migrate`
