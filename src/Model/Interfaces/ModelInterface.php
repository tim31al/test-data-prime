<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Model\Interfaces;

interface ModelInterface
{
    public function add(int $keyNumber, string $data): void;
}
