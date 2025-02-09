<?php

namespace Core\Validation;

class EmailRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Поле {$field} должно быть валидным email-адресом.";
        }
        return null;
    }
}