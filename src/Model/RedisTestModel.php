<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Model;

use App\Model\Interfaces\ModelInterface;
use Redis;

class RedisTestModel extends AbstractModel implements ModelInterface
{
    private const KEY_PREFIX = 'redis_test_entry:';

    private Redis $redis;

    public function __construct(Redis $redis, $maxDataLength)
    {
        $this->redis = $redis;
        $this->keyPrefix = static::KEY_PREFIX;
        $this->maxDataLength = $maxDataLength;
    }

    /**
     * Добавить запись.
     */
    public function add(int $keyNumber, string $data): void
    {
        $this->checkData($data);

        $key = $this->getKey($keyNumber);
        $this->redis->set($key, $data);
    }
}
