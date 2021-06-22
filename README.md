## Divsul Maps


#### Download and Install

```
git clone https://github.com/gerbesf/divsul-maps.git
cd divsul-maps
composer i 
npm i
```

#### Configure .env file
```

# DEFAULTS
APP_NAME="maps.divsul.org"
APP_ENV=production
APP_KEY=
APP_DEBUG=true
QUEUE_CONNECTION=redis

# DOMAIN
APP_URL=https://maps.divsul.org
APP_SSL=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=divsul_maps
DB_USERNAME=root
DB_PASSWORD=

# MAIL
MAIL_DRIVER=smtp
MAIL_HOST=email-smtp.eu-west-1.amazonaws.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=divsul@divsul.org
MAIL_FROM_NAME="DIVSUL"

# REDIS 
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=
REDIS_PORT=6379

# BOT SETTINGS
BOT_NAME="Ademir"
BOT_AVATAR="https://i.ibb.co/bRk8PP0/logo-divbot.png"

# DISCORD HOOK
DSC_MAP=https://discord.com/api/webhooks/812877633427734579/-kvFH8f1gudi15uHJW6PPxJErvTOD-zxdSJF5ru1FLj20jxbdilsDSllwMRndVKyk7OX

# Days for history
DIV_MAXD=5

# Votemap - Minutes per Steps
DIV_MAXV=6

# Min Players for validate map
DIV_MIN_PLAY_VALID=12

```

#### Setup - Unique Key

```
php artisan key:generate
```

#### Setup - Database

```
php artisan migrate
```


#### Setup - Create first admin 

```
php artisan create:admin_master {name} {nick} {email} {password}
```

#### Cron

```
# server sync
* * * * * php /var/www/divsul_org/divsul-maps/artisan reality:server

# maps sync
0 1 * * * php /var/www/divsul_org/divsul-maps/artisan reality:maps
```


##### Credits

Ferreira(Original)
