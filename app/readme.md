# Seed data
In database/seeds/DatabaseSeeder.php you should run Login seeder like this:

$this->call('LoginTableSeeder');
You should put into database/seeds file LoginTableSeeder.php with capital letter at the beginning.

Now, your file LoginTableSeeder.php file should look like this:

<?php

use Illuminate\Database\Seeder;

class LoginTableSeeder extends Seeder
{
    public function run()
    {

        // your code goes here
    }
}
you need to import Seeder with use at the beginning of file and again class name should start with capital letter.

Now you should run composer dump-autoload and now when you run php artisan db:seed it will work fine.


# Install dependencies error
Use flag `--ignore-platform-reqs`
eg: composer require jenssegers/mongodb --ignore-platform-reqs

# How to set up project
- Install PHP
- Install NodeJS and dependencies
- Install Bower and dependencies
- Install & run MongoDB
- Install & run Postgres
- Install & run Redis
- Install & run Elastichsearch
- Install & run GraphicMagick
- Run `node > nodejs es-index` to create ES mapping first

# Install specific composer tags

###run achivement job 
* * * * * php /home/ubuntu/limo-promotion/artisan schedule:run >> /dev/null 2>&1