<?php

namespace Core\Validation;

class RequiredRule implements ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string
    {
        if(empty($value)) {
            return "Поле {$field} обязательно для заполнения.";
        }
        return null;
    }


}