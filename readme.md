# Requirements
 1. \>=PHP5.5.9
 2. NodeJS and NPM
 3. Composer (run `curl -sS https://getcomposer.org/installer | php`)
 4. MySQL

# Deployment

 1. `cd /var/www && git clone ...`
 2. make sure that /var/www/koolbeans/public is the source directory of the web server 
 3. run `mv .env.example .env`
 4. change the configuration values in .env to what is necessary
 6. run `composer install`
 7. run `npm install`
 5. run `gulp`
 6. run `php artisan migrate` (if you need to install the database)
 7. run `php artisan optimize`
 8. run `php artisan route:cache`
