<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

require __DIR__.'/../vendor/autoload.php';

try {
    $app = new \App\App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage(), \PHP_EOL;
}