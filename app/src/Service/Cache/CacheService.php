<?php

namespace App\Service\Cache;

use App\Dto\Mapping\IDtoArrayResponseMapping;
use App\Dto\Response\QueryResponseDto;
use DateTime;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class CacheService implements ICacheService
{
    private IDtoArrayResponseMapping $responseMapping;
    private $client;

    public function __construct(IDtoArrayResponseMapping $responseMapping, string $host)
    {
        $this->responseMapping = $responseMapping;
        $this->client = RedisAdapter::createConnection($host);
    }

    public function get(array $tables, DateTime $from, DateTime $to): array
    {
        $queryResponseDto = new QueryResponseDto();
        $key = implode(',', [...$tables, $from->getTimestamp(), $to->getTimestamp()]);

        if ($this->client->exists($key)) {
            $data = $this->client->get($key);
            $queryResponseDto->source = ICacheService::SOURCE_CACHED;
            $queryResponseDto->timestamp = json_decode($data, true)['cached_timestamp'];

            return $this->responseMapping->transformToArray($queryResponseDto);
        }

        foreach ($tables as $table) {
            $data = $this->client->zrangebyscore('datamart_' . $table, $from->getTimestamp(), $to->getTimestamp());
            if (empty($data)) {
                $queryResponseDto->source = ICacheService::SOURCE_NOT_CACHED;
                $queryResponseDto->timestamp = time();

                return $this->responseMapping->transformToArray($queryResponseDto);
            }
        }

        $this->client->set($key, json_encode(['cached_timestamp' => time()]));
        $queryResponseDto->source = ICacheService::SOURCE_CACHED;
        $queryResponseDto->timestamp = time();

        return $this->responseMapping->transformToArray($queryResponseDto);
    }

    public function calculate(string $table, DateTime $datetime, array $data): void {
        $this->client->zadd('datamart_' . $table, $datetime->getTimestamp(), json_encode($data));
    }

    public function getData(string $key, $is_associative = true): array
    {
        return json_decode($this->client->get($key), $is_associative);
    }
}