<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Model;

use Redis;

class RedisTestModel extends AbstractModel
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
