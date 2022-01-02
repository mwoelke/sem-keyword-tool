#!/bin/bash
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application composer install" 
docker exec sem-keyword_php-apache gosu application php /app/bin/console doctrine:schema:create --no-interaction
docker exec sem-keyword_php-apache gosu application php /app/bin/console doctrine:fixtures:load --no-interaction
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application yarn encore dev"
