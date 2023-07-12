<?php

namespace App\Services\Contracts;

use App\Models\Store;

interface StoreServiceInterface
{
    public function create(array $data): Store;
    public function update(Store $store, array $data): Store;
    public function delete(Store $store): void;
    public function getAll(): array;
    public function getByUser(int $userId): array;
}
