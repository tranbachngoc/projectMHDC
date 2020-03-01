#!/bin/sh

##clear cache
php artisan cache:clear

#refresh db
php artisan migrate:refresh

#remove mongodb
#mongo limocab --eval "db.dropDatabase()"

#reset redis
echo FLUSHALL | redis-cli

#seed data
php artisan db:seed

#rebuild the app
#chmod +x build.sh
#./build.sh