<?php


namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\DatetimeOneMonthAgo;

class CalculateRequest extends BaseRequest
{
    #[Assert\Type('string')]
    #[Assert\Choice(choices: ['stats_dep_a', 'stats_dep_b', 'stats_dep_c'])]
    #[Assert\NotBlank()]
    protected string $table_name;

    #[Assert\DateTime(format: 'Y-m-d\TH:i', message: "Enable time is not a valid datetime.")]
    #[Assert\NotBlank()]
    #[DatetimeOneMonthAgo()]
    protected string $datetime;

    protected array $data;


    protected function populate(): void {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}