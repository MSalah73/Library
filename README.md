# Library
This application is a demonstration of Laravel skills with RESTful api. The library application lets you add, edit, delete, search, sort, and download books.
## Usage
* Clone or download the project. 
## Installation
* Install [Laravel 6.x](https://laravel.com/docs/6.x) and PHP Dependency Manager [Composer](https://getcomposer.org/download/).
* Install [XAMPP](https://www.apachefriends.org/download.html).
## Algolia
Make an account with [Algolia](https://www.algolia.com/) and look for `ALGOLIA_SECRET` and `ALGOLIA_APP_ID` and place them in the project's `.env` file.
Example:
```
ALGOLIA_SECRET=DEADBEEF......
ALGOLIA_APP_ID=ABC....
```
## Setup Database
One of the easiest databases to set up is SQLite. All you have to do is make sure the `.env`'s `DB_CONNECTION=sqlite`. After which just create a database file via this command `touch database/database.sqlite` from the project root directory.  
## Install Dependencies
* Install the project's dependencies via `php composer install`
## Database Migration
* Run `php artisan migrate` to instantiate migration files.
## Connect the Model With Aloglia
* Run `php artisan scout:import 'App\Book'` to connect the model's data with the Alogila engine.
## Deployment via Heroku
*  Make a Heroku account
* Run `echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile` in your root directory.
* Commit and your changes and run `git push heroku master` to deploy it to Heroku.
* Setup Postgres from the resources in Heroku's project page.
* Adding some configuration in Heroku base on .env file from the Settings then Config Vars.* 
* Add the following as shown in the photo.
>![Env to include ](https://imgur.com/KqFVNhZ.jpg)
* On Heroku's project page, click more and then run console. Run 
    * `php artisan migrate`
    * `php artisan scout:import 'App\Book'`
* That's it!
### License
[MIT License](https://opensource.org/licenses/MIT)