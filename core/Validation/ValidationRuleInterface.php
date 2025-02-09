<?php

namespace Core\Validation;

interface ValidationRuleInterface
{
    public function validate(string $field, mixed $value, array|string $params = []): ?string;

}