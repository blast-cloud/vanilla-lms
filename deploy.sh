#! /bin/bash

# pull latest changes from repo
git pull

# change file permissions
sudo chmod -R 777 storage/logs/laravel.log
			 
sudo chmod -R 777 storage/framework/sessions*
			 
sudo chmod -R 777 storage/framework/views*
			 
sudo chmod -R 777 storage/framework/cache
			 
sudo chmod -R 777 vendor/laravel/framework/src/Illuminate/Filesystem*
			 
sudo chmod -R 777 bootstrap/cache 
                         
sudo chmod -R 777 storage*

sudo chmod -R 777 storage/framework/cache/data
			 
sudo chmod -R 777 resources

# run migrations
php artisan migrate --force

#clear cache
php artisan optimize:clear

#clear route & others
php artisan route:clear
php artisan config:clear
php artisan cache:clear

#restart webserver
systemctl restart apache2
