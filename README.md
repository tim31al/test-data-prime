# ТЗ

## Запуск

``` 
git clone git@github.com:tim31al/test-data-prime.git my_dir
cd my_dir
docker-compose up -d
docker-compose exec -u app app composer install
docker-compose exec -u app app php bin/app.php
```

## Результат 100 000
![Screenshot](test.jpg)

## Результат 1
![Screenshot](test-one.jpg)
