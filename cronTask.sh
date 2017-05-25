#!/bin/bash

cd /var/www/smssurvey
rm app/storage/cron.lock
/usr/bin/php artisan cron:run
