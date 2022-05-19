<?php

/*
 *
 * (c) Alexandr Timofeev <tim31al@gmail.com>
 *
 */

namespace App\Utils;

class TestHelper
{
    public static function getStart(): float
    {
        return microtime(true);
    }

    public static function getProcessedMessage(int $start, string $service, int $count): string
    {
        $finish = microtime(true);

        return sprintf(
            '%s service processed %d records in %s seconds%s',
            $service,
            $count,
            number_format($finish - $start, 4),
            \PHP_EOL);
    }
}
