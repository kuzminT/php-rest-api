## Laravel REST API example

Example REST API on **Laravel Framework**. Based on [Avito test task](https://github.com/avito-tech/verticals/blob/master/trainee/backend.md) about rest json for announcements.

In the future, it is planned to make different branches for creating applications with various frameworks and libraries (like Slim, Symphony and may be others).

## Usage 

To start app in docker use `docker-compose up --build` in the root directory. After the docker containers are started, execute:
    
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
    docker-compose exec app php artisan migrate --seed
    docker-compose exec app php artisan config:cache


## Routes

**GET | api/announcements** - get lists of all announcements with pagination 10 items on page

**POST     | api/announcements**    - create new announcement. Expect data: title (max 200), description (max 1000), user_id integer, photos array (optional) - list of url (string) for photos linked with this announcement. Max 3 photos for announcement. 
Expect options sort (price, crated_at) and return ordered by this field list of items. If before field setted `-` than return items in DESC order. By default, without options, return all items sorted by **created_at DESC**.

**GET|HEAD | api/announcements/{id}** - get one announcement. Expect options fields that can contain params photos and description. In that case return additional data.
    
## Tests
    
Execute this command to run tests:

    docker-compose exec app composer test
    