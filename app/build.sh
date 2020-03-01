#!/bin/sh
#go parent and execute the script
#cd ..

#checkout source code
#git fetch && git checkout develop
#git pull -f
git reset --hard HEAD
git pull origin master

#set write permission for cache folder
#TODO - should not use 777
sudo chmod 777 bootstrap/cache -R
sudo chmod 777 storage/logs -R
sudo chmod 777 storage/framework -R
sudo chmod 777 storage/app -R
#note - should not set 777 here, just for development env
sudo chmod 777 public/uploads -R

bower install --allow-root
composer update

#run gulp task
#gulp run:dev