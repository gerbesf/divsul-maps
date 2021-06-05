## Divsul Maps

under construction

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


##### Crédits

Ferreira(Original)
