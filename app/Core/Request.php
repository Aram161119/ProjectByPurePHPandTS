<?php

namespace App\Core;

class Request
{
    use Validator {
        validate as protected coreValidate;
    }

    protected array $data;
    protected array $getData;
    protected array $fileData;

    public function __construct()
    {
        $this->data = $_POST;
        $this->getData = $_GET;
        $this->fileData = $_FILES;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return $this->coreValidate($this->data, $this->rules());
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->fileData;
    }

    /**
     * @return array
     */
    public function getSort(): array
    {
        if (!isset($this->getData['sort'])) {
            return [];
        }

        $result = [];

        foreach ($this->getData['sort'] as $sortExpression) {
            $sign = $sortExpression[0];

            $field = ltrim($sortExpression, $sign);
            $orderType = $sign === '-' ? 'desc' : 'asc';

            $result[$field] = $orderType;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->getErrors();
    }
}
