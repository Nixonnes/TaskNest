<?php

namespace Core\Validation;

class ConfirmedRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        $confirmationField = $field . '_confirmation';

        if (!isset($_POST[$confirmationField]) || $value !== $_POST[$confirmationField]) {
            return "The {$field} confirmation does not match.";
        }
        return null;
    }
}