## Laravel REST API example

Example REST API on **Laravel Framework**. Based on [Avito test task](https://github.com/avito-tech/verticals/blob/master/trainee/backend.md) about rest json for announcements.

In the future, it is planned to make different branches for creating applications with various frameworks and libraries.

## Start app in docker

After the docker containers are started, execute:
    
    # Pull up all composer dependencies
    docker-compose exec app composer install
    
    cp .env.example .env
    docker-compose exec app vim .env
    #Change the database configuration as below.
    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=test
    DB_USERNAME=test
    DB_PASSWORD=test
    
    # Additional rights settings
    docker-compose exec app chown -R www-data:www-data  storage
    docker-compose exec app php artisan key:generate
    # If the connection to the database is configured correctly, 
    # the migrations will be performed
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan config:cache
    
    
