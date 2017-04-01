# CarbonX League

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