<?php

namespace Core\Validation;

use Core\Database;
use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

class Validator
{
    private array $errors = [];
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    public function validate(array $data, array $rules): array
    {
        foreach($rules as $field => $fieldRules) {
            if($error = $this->applyRules($field,$data[$field] ?? null,explode('|', $fieldRules))) {
                $this->errors[$field] = $error;
            };
        }
        return $this->errors;
    }

    /**
     * @throws Exception
     */
    protected function applyRules(string $field, mixed $value, array $rules)
    {
        foreach($rules as $rule) {
            [$ruleName, $params] = $this->parseRule($rule);

            $ruleClass = $this->resolveRuleClass($ruleName);
            if ($ruleClass instanceof ValidationRuleInterface) {
                $error = $ruleClass->validate($field, $value, $params);
                if ($error !== null) {
                    return $error; // Останавливаемся на первой ошибке
                }
            }
        }
        return null;
    }
    private function parseRule(string $rule): array
    {
        $parts = explode(':', $rule);
        $ruleName = ucfirst($parts[0]) . 'Rule';
        $params = $parts[1] ?? '';
        return [$ruleName, $params];
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    private function resolveRuleClass($rule)
    {
        $ruleClass = "Core\\Validation\\{$rule}";
        if (class_exists($ruleClass)) {
            return $this->container->get($ruleClass);
        }
        throw new Exception("Rule {$rule} not found");
    }
}