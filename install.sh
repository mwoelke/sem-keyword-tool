#!/bin/bash
fixtures=1
while getopts "f" arg; do
    case $arg in 
        f)
            fixtures=0
            ;;
    esac
done
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application php bin/console doctrine:schema:drop --force --no-interaction" 
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application composer install --no-dev" 
docker exec sem-keyword_php-apache gosu application php /app/bin/console doctrine:schema:create --no-interaction
if  [ "$fixtures" == 1 ]; then
    docker exec sem-keyword_php-apache gosu application php /app/bin/console doctrine:fixtures:load --no-interaction
fi
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application yarn install --production=true"
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application yarn encore prod"