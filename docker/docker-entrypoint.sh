#!/usr/bin/env sh

composer install
npm install
php yii migrate --interactive=0
php yii cache/flush-all

exec "$@"
