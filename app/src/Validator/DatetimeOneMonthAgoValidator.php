<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DatetimeOneMonthAgoValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $requested = new \DateTime($value);
        $oneMonthAgo = new \DateTime('-1 month');

        if ($requested < $oneMonthAgo) {
            $this->context->buildViolation($constraint->message, [
                '%string%' => $oneMonthAgo->format('Y-m-d H:i')
            ])->addViolation();
        }
    }
}