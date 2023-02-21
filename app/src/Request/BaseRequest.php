<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
        if ($this->autoValidateRequest()) {
            $validation = $this->validate();
            if ($this->isValidationFailed($validation)) {
                $this->sendValidationFailedResponse($validation);
            }
        }
    }

    public function validate(): ConstraintViolationListInterface {
        return $this->validator->validate($this);
    }

    protected function isValidationFailed(ConstraintViolationListInterface $errors): bool
    {
        return count($errors) != 0;
    }

    protected function sendValidationFailedResponse(ConstraintViolationListInterface $errors): void {
        $messages = ['message' => 'validation_failed', 'errors' => []];

        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }

        $response = new JsonResponse($messages, JsonResponse::HTTP_BAD_REQUEST);
        $response->send();
    }

    public function getRequest(): Request {
        return Request::createFromGlobals();
    }

    protected function populate(): void {
        foreach ($this->getRequest()->query as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    protected function autoValidateRequest(): bool
    {
        return true;
    }
}