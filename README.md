iBeacon Manager
=============================

Install steps
=============================
- clone repository `git clone git@github.com:iMihael/ibeacon-manager.git`
- configure web server (you can use nginx.conf)
- install dependencies via composer `composer install`
- create mysql database
- configure db access in config/db.php
- run migrations `yii migrate/up`
- chmod assets folder `chmod 777 web/assets/ -R`
- login with test account `admin@admin.com / 123456`