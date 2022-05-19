<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

return [
    'db_connection' => [
        'driver' => 'mysql',
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'dbname' => getenv('DB_NAME'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
    ],
    'redis' => [
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
    ],
    'max_data_length' => 2000,
];
