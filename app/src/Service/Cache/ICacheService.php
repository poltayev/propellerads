<?php

namespace App\Service\Cache;

use DateTime;

interface ICacheService
{
    public const SOURCE_NOT_CACHED = 'DWH';
    public const SOURCE_CACHED = 'CACHE';

    public function get(array $datamarts, DateTime $from, DateTime $to): array;
    public function calculate(string $table, DateTime $datetime, array $data): void;
}