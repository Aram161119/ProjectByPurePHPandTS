<?php

namespace App\Core;

abstract class BaseManager
{
    /**
     * @param Model $model
     */
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array $search
     * @param array $sorting
     * @return array
     */
    public function index(array $search = [], array $sorting = []): array
    {
        return $this->model->get($search, $sorting);
    }

    /**
     * @param array $fields
     * @return bool
     */
    public function create(array $fields): bool
    {
        return $this->model->create($fields);
    }

    /**
     * @param int $id
     * @param array $fields
     * @return bool
     */
    public function update(int $id, array $fields): bool
    {
        $record = $this->model->findById($id);

        if (!$record) {
            return false;
        }

        return $this->model->update($id, $fields);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        return $this->model->findById($id);
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function find(array $data): ?array
    {
        return $this->model->find($data);
    }
}