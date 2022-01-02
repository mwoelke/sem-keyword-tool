# SEM keyword tool
## About
This tool was created for the course "Web- & App-Engineering I" at the Baden-Württemberg Cooperative State University.
Chances are you should not use this in production, but it might serve as reference.

## Usage
This tool allows for fast grouping of SEO keywords into keyword groups.
Keywords can be imported via CSV or through the API.

You can add "assignment rules" to automatically add keywords to groups. 
This may be any valid PCRE regex pattern.

Keyword groups can be downloaded with all their assigned keywords as CSV.

A csv with test data is provided: example_import.csv
Import this on the _Import_ page (Has headers = true)

## Install
I highly recommand utilizing the docker setup provided in this repository.

1. Clone repository
2. Build docker images via `docker-compose build` 
3. Start containers via `docker-compose up -d`
4. Execute `install.sh` to setup the container and install/compile dependencies. Use flag -f to _not_ load example data and test credentials.
5. (optional) For use in production, change database credentials in `docker-compose.yml` and `project/.env`

This will open a webserver on port 8080 and phpMyAdmin on port 8081 for debugging/testing.
Test credentials: user@user.de:sh7up#KT!

## API
This tool utilizes API Platform. OpenAPI docs can be found on `/api/`.
Use HTTP Basic Auth when calling the API manually.

## Dependencies
- PHP >8.0
- MariaDB 

## Used technologies
- Symfony 5.4 LTS
- Doctrine ORM
- Vue 2
- API Platform 
- Webpack Encore
- Bootstrap 5.1 w/ SCSS

## License
AGPL 3.0, see LICENSE file