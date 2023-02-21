<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class QueryRequest extends BaseRequest
{
    #[Type('array')]
    #[NotBlank()]
    protected array $datamarts;

    #[Assert\DateTime(format: 'Y-m-d\TH:i', message: "Enable time is not a valid datetime.")]
    #[NotBlank()]
    protected string $date_time_from;

    #[Assert\DateTime(format: 'Y-m-d\TH:i', message: "Enable time is not a valid datetime.")]
    #[NotBlank()]
    protected string $date_time_to;
}