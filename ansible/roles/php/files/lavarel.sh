#!/bin/bash

if [ ! -d "/usr/local/lib/lavarel-installer" ]; then
    git clone https://github.com/laravel/installer.git /usr/local/lib/laravel-installer
    ln -s /usr/local/lib/laravel-installer/laravel /usr/local/bin/laravel-installer
    chmod +x /usr/local/lib/laravel-installer/laravel
fi

cd /usr/local/lib/laravel-installer

git checkout master
git pull origin master
git checkout `git describe --abbrev=0 --tags`
composer.phar install
