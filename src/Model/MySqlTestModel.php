<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Model;

use PDO;

class MySqlTestModel extends AbstractModel
{
    private const TABLE = 'entries';
    private const KEY_PREFIX = 'mysql_test_entry:';
    private const KEY_LENGTH = 32;

    private PDO $pdo;

    public function __construct(PDO $pdo, string $maxDataLength)
    {
        $this->pdo = $pdo;
        $this->keyPrefix = static::KEY_PREFIX;
        $this->maxDataLength = $maxDataLength;
    }

    /**
     * Инициализация таблицы.
     */
    public function init(): void
    {
        $sql = 'CREATE TABLE IF NOT EXISTS '.static::TABLE.' ('.
            'id VARCHAR('.static::KEY_LENGTH.') NOT NULL PRIMARY KEY, '.
            'data TEXT NOT NULL '.
            ')';

        $this->pdo->query($sql);
    }

    /**
     * Добавить запись.
     */
    public function add(int $keyNumber, string $data): void
    {
        $this->checkData($data);

        $sql = 'INSERT INTO '.static::TABLE.' (id, data) VALUES(?, ?) '.
        'ON DUPLICATE KEY UPDATE data = ?';

        $key = $this->getKey($keyNumber);

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $key);
        $stmt->bindParam(2, $data);
        $stmt->bindParam(3, $data);

        $stmt->execute();
    }
}
