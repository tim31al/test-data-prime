<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Model;

use App\Model\Exceptions\ModelDataLengthException;
use App\Model\Interfaces\ModelInterface;
use function mb_strlen;

abstract class AbstractModel implements ModelInterface
{
    protected string $keyPrefix;
    protected int $maxDataLength;

    /**
     * Первичный ключ.
     */
    protected function getKey(int $number): string
    {
        return $this->keyPrefix.$number;
    }

    /**
     * Проверка длины строки.
     *
     * @throws \App\Model\Exceptions\ModelDataLengthException
     */
    protected function checkData(string $data): void
    {
        if (mb_strlen($data) > $this->maxDataLength) {
            throw new ModelDataLengthException('Data must be below '.$this->maxDataLength);
        }
    }
}
