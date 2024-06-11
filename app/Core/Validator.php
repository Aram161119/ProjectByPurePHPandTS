<?php
namespace App\Core;

trait Validator
{
    private array $errors = [];

    /**
     * @param array $data
     * @param array $rules
     * @return bool
     */
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

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $data
     * @param string $field
     * @param string $rule
     * @return bool
     */
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
                $this->errors[$field][] = "The $field field must be no more than $maxLength characters.";
                return false;
            }
        }

        if (preg_match('/file:(.+)/', $rule, $matches)) {
            if (!isset($_FILES[$field]) || $_FILES[$field]['error'] != UPLOAD_ERR_OK) {
                $this->errors[$field][] = "The $field field must be a valid file.";
                return false;
            }

            $allowedExtensions = explode(',', $matches[1]);
            $fileExtension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);

            if (!in_array($fileExtension, $allowedExtensions)) {
                $this->errors[$field][] = "The $field field must have a valid file extension. Allowed extensions are: " . implode(', ', $allowedExtensions) . ".";
                return false;
            }
        }

        if ($rule === 'nullable' && $value !== null) {
            return false;
        }

        if ($rule === 'integer' && !is_int($value)) {
            return false;
        }

        if ($rule === 'string' && !is_string($value)) {
            return false;
        }

        return true;
    }
}
