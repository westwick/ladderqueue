# CarbonX League

## now with a docker setup, to start the project take the following steps:

1. To get the docker containers up and running, from terminal CD into the ./laradock-LaraDock-ToolBox directory,
run: docker-compose -d nginx mariadb to start all of the necessary application docker containers
If you would like terminal output from these containers to see that start up succeeded / check any errors then you may omit the -d argument from docker-compose

2. If a fresh install / you have not yet run composer to generate the /vendor files && autoload.php then you must do so now and run composer install from the workspace docker container

Any composer or php artisan commands must be run from within the laradocklaradocktoolbox_workspace_1 container. To enter this container from BASH / terminal you must run:

docker exec -it laradocklaradocktoolbox_workspace_1 bash

You may then run composer install , php artisan migrate etc...

3. After installing all the composer dependencies you're going to want to setup the DB with: php artisan migrate

4. If you do not yet have a .env file setup then make a copy / rename from .env.example in this repo

5. After saving the .env file, run: php artisan key:generate from the workspace container to have the laravel secret key generated allowing the app to finally start and be served from root port 80 of the docker / docker-machine IP, on windows / my pc this ip address is: http://192.168.99.100/ (address where the web app is accessed)

Basic laravel 5.4 setup, follow instructions below

###Laravel
####Prerequisites

Download and install the latest versions of:

 - Composer
 - Virtualbox 
 - Vagrant

####Steps
1. Rename `Homestead.sample.yaml` to `Homestead.yaml`, configure as needed
2. Add 192.168.10.10 carbonx.app to `/etc/hosts`, *file location depends on your OS*
3. Rename `.env.sample` to `.env`, configure as needed
4. `composer install`
5. `vagrant box add laravel/homestead`
6. `vagrant up`
7. `vagrant ssh`
8. cd to project directory
9. `php artisan key:generate`
10. `php artisan migrate` or import sql file
11. open http://carbonx.app and make sure everything works

####Additional Resources
 - https://laravel.com/docs/5.4/