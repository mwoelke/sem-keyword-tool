FROM webdevops/php-apache:8.0-alpine

EXPOSE 80

RUN apk add --no-cache nodejs-current \
    && apk add --no-cache npm
RUN npm install --global yarn