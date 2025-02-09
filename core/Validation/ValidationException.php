<?php

namespace Core\Validation;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors, $message = "Validation failed", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }
    public function getErrors(): array
    {
        return $this->errors;
    }
}