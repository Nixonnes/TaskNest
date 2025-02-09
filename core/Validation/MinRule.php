<?php

namespace Core\Validation;

class MinRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        $min = (int) $params[0] ?? 0;
        if (strlen($value) < $min) {
            return "Поле {$field} должно содержать минимум {$min} символов.";
        }
        return null;
    }
}