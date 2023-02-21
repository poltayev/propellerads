<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

#[\Attribute] class DatetimeOneMonthAgo extends Constraint
{
    public string $message = 'Datetime should be greater than %string%.';
}