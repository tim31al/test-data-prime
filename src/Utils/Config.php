<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Utils;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class Config
{
    private const SETTINGS_FILE = 'settings.php';
    private const SERVICES_FILE = 'services.php';
    private const CONFIG_DIR = __DIR__.'/../../config/';

    /**
     * Создает и возвращает контейнер
     *
     * @throws \Exception
     */
    public static function getContainer(): ContainerInterface
    {
        $c = new ContainerBuilder();
        $c->addDefinitions(
            static::CONFIG_DIR.static::SETTINGS_FILE,
            static::CONFIG_DIR.static::SERVICES_FILE
        );

        return $c->build();
    }
}
