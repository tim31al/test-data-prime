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

class App
{
    private const MAX_ITEMS = 100000;
    private MySqlTestModel $mySqlTestModel;
    private RedisTestModel $redisTestModel;

    public function __construct()
    {
        $container = Config::getContainer();
        $this->mySqlTestModel = $container->get(MySqlTestModel::class);
        $this->redisTestModel = $container->get(RedisTestModel::class);

        $this->mySqlTestModel->init();
    }

    public function run(string $data = null): void
    {
        if (!$data) {
            $length = rand(500, 1000);
            $data = bin2hex(random_bytes($length));
        }

        echo 'Тест MySql', \PHP_EOL;
        $start = TestHelper::getStart();
        $this->runInsert($this->mySqlTestModel, $data);
        echo TestHelper::getProcessedMessage($start, 'Mysql', static::MAX_ITEMS);

        echo \PHP_EOL, '********************';

        echo 'Тест Redis', \PHP_EOL;
        $start = TestHelper::getStart();
        $this->runInsert($this->redisTestModel, $data);
        echo TestHelper::getProcessedMessage($start, 'Redis', static::MAX_ITEMS);
    }

    private function runInsert(ModelInterface $model, string $data): void
    {
        foreach (range(0, static::MAX_ITEMS) as $keyNumber) {
            $model->add($keyNumber, $data);
        }
    }
}
