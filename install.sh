#!/bin/bash
fixtures=1
while getopts "f" arg; do
    case $arg in 
        f)
            fixtures=0
            ;;
    esac
done
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application composer install" 
if  [ "$fixtures" == 1 ]; then
    docker exec sem-keyword_php-apache bash -c "cd /app && gosu application composer require doctrine/doctrine-fixtures-bundle"
    docker exec sem-keyword_php-apache gosu application php /app/bin/console doctrine:fixtures:load --no-interaction
fi
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application yarn install "
docker exec sem-keyword_php-apache bash -c "cd /app && gosu application yarn encore prod"