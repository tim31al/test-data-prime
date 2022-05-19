<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

use App\Model\MySqlTestModel;
use App\Model\RedisTestModel;
use Psr\Container\ContainerInterface;

return [
    PDO::class => function (ContainerInterface $container): PDO {
        $dbConf = $container->get('db_connection');
        $dsn = sprintf(
            '%s:host=%s;port=%s;dbname=%s',
            $dbConf['driver'],
            $dbConf['host'],
            $dbConf['port'],
            $dbConf['dbname']
        );

        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, $dbConf['user'], $dbConf['password'], $opt);
    },

    Redis::class => function () {
        $redis = new Redis();
        $redis->connect(
            getenv('REDIS_HOST'), getenv('REDIS_PORT')
        );

        return $redis;
    },

    MySqlTestModel::class => function (ContainerInterface $container): MySqlTestModel {
        $pdo = $container->get(PDO::class);
        $maxDataLength = $container->get('max_data_length');

        return new MySqlTestModel($pdo, $maxDataLength);
    },

    RedisTestModel::class => function (ContainerInterface $container): RedisTestModel {
        $redis = $container->get(Redis::class);
        $maxDataLength = $container->get('max_data_length');

        return new RedisTestModel($redis, $maxDataLength);
    },
];
