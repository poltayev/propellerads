<?php


namespace App\Dto\Mapping;


use App\Dto\Response\QueryResponseDto;

class QueryDtoResponseMapping implements IDtoArrayResponseMapping
{
    public function transformToArray(QueryResponseDto $queryResponseDto): array
    {
        return [
            'source' => $queryResponseDto->source,
            'timestamp' => $queryResponseDto->timestamp,
        ];
    }

}