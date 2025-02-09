<?php

namespace Core\Validation;

class MaxRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        if(is_string($params)) {
            $max = (int)$params ?? 0;
        } else {
            $max = (int) $params[0] ?? 0;
        }
        if (strlen($value) > $max) {
            return "Поле {$field} должно содержать максимум {$max} символов.";
        }
        return null;
    }

}