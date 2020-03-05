## Запуск приложения в докере

После того, как контейнеры докера будут запущены, выполнить:
    
    # Подтянуть все зависимости composer
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
    
    # Дополнительная настройка прав
    docker-compose exec app chown -R www-data:www-data  storage
    docker-compose exec app php artisan key:generate
    # Если соединение с базой настроено правильно, то миграции выполнятся
    docker-compose exec app php artisan migrate
    docker-compose exec app php artisan config:cache
    
    
