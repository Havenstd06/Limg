# Limg
## An open source image hosting service powered by Laravel
  
<img src="https://limg.app/i/gQHOGpS.png/500" alt="limg logo">
  
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>

<hr>

## Features
- Upload your image via file, url or ShareX !
- Manage your image (custom title, public or private, delete, custom size...)
- Custom Domain for ShareX upload (be sure to add a redirect from the new domain to the main domain)
- Discord Webhook for every new image uploaded
- Add image into an album (custom name, public or private, delete)
- Backpack Admin Panel (ready to use)
- Like System
- Possibility to choose to generate shorter links for ShareX uploads
- Public & Private API

## Requirement
- [**PHP**](https://php.net) 7.4+
- Database server: [MySQL](https://www.mysql.com) or [**MariaDB**](https://mariadb.org)
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org/) with npm

## Installation
* clone the repository: `git clone https://github.com/Havenstd06/Limg`
* create a database
* install: `composer install`
* create configuration env file `.env` refer to `.env.example`
* generate a new application key `php artisan key:generate`
* setup database tables: `php artisan migrate:fresh --seed` (**highly recommanded**)
* create storage link `php artisan storage:link`
* install node_module `npm i && npm run dev` (or npm run prod)
* Default username: Havens - Password : password (see `database/factories/UserFactory.php` & `database/seeds/UsersTableSeeder`)

## Setup Discord Login
* go on https://discordapp.com/developers/applications
* create new application
* copy `CLIENT ID` & `CLIENT SECRET`
* paste on `.env` (`CLIENT ID` => `DISCORD_KEY` & `CLIENT SECRET` => `DISCORD_SECRET`)
* go on OAuth2 page and add redirect link : `https://YourApp.Domain/login/discord/callback` 
* add this redirect link in `.env` => `DISCORD_REDIRECT_URI`

## API
### API endpoint
`https://limg.app/api`

### Authorization Header
For some page (with sensitive information) an API key is necessary, you must add:  
`Authorization:` `{UserApiToken}`

### Stats
* `/stats/global` - Return the number of images, albums and users.

### User
* `/user/{Username}` - Return the user's public information.
* `/user/{Username}` (with "Authorization") - Return the user's private information.
* `/user/{Username}/images/discover` - Returns all the user's "discover" images.
* `/user/{Username}/images/all` (with "Authorization") - Return all user images.
* `/user/{Username}/images/public` (with "Authorization") - Returns all the user's "public" images.
* `/user/{Username}/images/private` (with "Authorization") - Returns all the user's "private" images.

### Images
* `/images/discover` - Return all "discover" images. 
* `/images/{pageName}` - Return the image of the specified image "pageName" (If public).  
* `/images/{pageName}` (with "Authorization") - Return the image of the specified image "pageName" (If private).
* `/images/delete/{pageName}` (with "Authorization") - Delete the image, only if you own the image (does not work with anonymous user images).

### Upload
* `/upload` - ShareX Compatible API.

## Backpack Admin Panel
This software uses Backpack for Laravel as a dependency. So when you use this in production, you'll need a Backpack license. You can get a free non-commercial license here, but if your project is for commercial purposes you need to pay 69 EUR for a license.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.
Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
