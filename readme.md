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
 8. run `php artisan route:cache` (if it doesn't work, that's fine, app is not that big anyway)
 8. run `crontab -e` as root and add `* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1`

# Issues

 If Xero stops working suddendly, upload a new keypair as stated
 http://developer.xero.com/documentation/advanced-docs/public-private-keypair/ and
 http://developer.xero.com/documentation/getting-started/private-applications/
 
 The pem file should be stored as /etc/ssl/certs/koolbeans.pem
