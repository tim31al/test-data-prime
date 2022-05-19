<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App;

use App\Model\Interfaces\ModelInterface;
use App\Model\MySqlTestModel;
use App\Model\RedisTestModel;
use App\Utils\Config;
use App\Utils\TestHelper;
use const PHP_EOL;

class App
{
    private const MAX_ITEMS = 100000;

    private MySqlTestModel $mySqlTestModel;
    private RedisTestModel $redisTestModel;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function __construct()
    {
        $container = Config::getContainer();
        $this->mySqlTestModel = $container->get(MySqlTestModel::class);
        $this->redisTestModel = $container->get(RedisTestModel::class);

        $this->mySqlTestModel->init();
    }

    /**
     * Запуск тестов.
     */
    public function run(string $data = null): void
    {
        if (!$data) {
            $data = $this->getRandomString();
        }

        $this->runTest('Mysql', $this->mySqlTestModel, $data);

        echo PHP_EOL, '********************', PHP_EOL;

        $this->runTest('Redis', $this->redisTestModel, $data);
    }

    private function runTest(string $serviceName, ModelInterface $model, string $data): void
    {
        echo 'Тест '.$serviceName, PHP_EOL;

        $start = TestHelper::getStart();

        foreach (range(0, static::MAX_ITEMS) as $keyNumber) {
            $model->add($keyNumber, $data);
        }

        echo TestHelper::getProcessedMessage($start, $serviceName, static::MAX_ITEMS);
    }

    private function getRandomString(): string
    {
        $length = rand(500, 1000);

        return bin2hex(random_bytes($length));
    }
}
