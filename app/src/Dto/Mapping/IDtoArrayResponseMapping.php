<?php


namespace App\Dto\Mapping;


use App\Dto\Response\QueryResponseDto;

interface IDtoArrayResponseMapping
{
    public function transformToArray(QueryResponseDto $queryResponseDto): array;
}