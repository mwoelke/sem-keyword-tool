FROM webdevops/php-apache:8.0-alpine

EXPOSE 80

# install node and npm
RUN apk add --no-cache nodejs-current \
    && apk add --no-cache npm
# install yarn (package manager used by symfony webpack encore)
RUN npm install --global yarn

# create alias for php executable since this is not in the path for some reason 
RUN alias php="/usr/local/bin/php"
