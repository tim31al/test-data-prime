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
    private const ONE_ITEM_DECIMALS = 16;

    private MySqlTestModel $mySqlTestModel;
    private RedisTestModel $redisTestModel;
    private int $maxItems;

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function __construct()
    {
        $this->maxItems = self::MAX_ITEMS;

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

        $this->printSplitter();

        $this->runTest('Redis', $this->redisTestModel, $data);

        $this->printSplitter();

        $this->runTestOne('Mysql', $this->mySqlTestModel);

        $this->printSplitter();

        $this->runTestOne('Redis', $this->redisTestModel);

        echo PHP_EOL;
    }

    public function setMaxItems(int $maxItems): self
    {
        $this->maxItems = $maxItems;

        return $this;
    }

    private function runTestOne(string $service, ModelInterface $model): void
    {
        $str = $this->getRandomString();
        $count = 1;

        echo $service.' add one record', PHP_EOL;
        $start = TestHelper::getStart();
        $model->add($count, $str);
        echo TestHelper::getProcessedMessage($start, $service, $count, static::ONE_ITEM_DECIMALS);
    }

    private function runTest(string $serviceName, ModelInterface $model, string $data): void
    {
        echo 'Тест '.$serviceName, PHP_EOL;

        $start = TestHelper::getStart();

        foreach (range(0, $this->maxItems) as $keyNumber) {
            $model->add($keyNumber, $data);
        }

        echo TestHelper::getProcessedMessage($start, $serviceName, $this->maxItems);
    }

    private function getRandomString(): string
    {
        $length = rand(500, 1000);

        return bin2hex(random_bytes($length));
    }

    private function printSplitter(): void
    {
        echo PHP_EOL, '********************', PHP_EOL;
    }
}
