<?php
namespace App\Core;

class Validator
{
    private array $errors = [];

    public function validate(array $data, array $rules): bool
    {
        foreach ($rules as $field => $ruleSet) {
            $rulesArray = explode('|', $ruleSet);
            foreach ($rulesArray as $rule) {
                if (!$this->applyRule($data, $field, $rule)) {
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function applyRule(array $data, string $field, string $rule): bool
    {
        $value = $data[$field] ?? null;
        if ($rule === 'required' && empty($value)) {
            $this->errors[$field][] = "The $field field is required.";
            return false;
        }
        if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "The $field field must be a valid email address.";
            return false;
        }
        if (preg_match('/min:(\d+)/', $rule, $matches)) {
            $minLength = $matches[1];
            if (strlen($value) < $minLength) {
                $this->errors[$field][] = "The $field field must be at least $minLength characters.";
                return false;
            }
        }
        if (preg_match('/max:(\d+)/', $rule, $matches)) {
            $maxLength = $matches[1];
            if (strlen($value) > $maxLength) {
                $this->errors[$field][] = "The $field field must be at least $maxLength characters.";
                return false;
            }
        }

        return true;
    }
}
