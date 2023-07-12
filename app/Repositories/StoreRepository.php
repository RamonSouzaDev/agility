<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\Contracts\StoreRepositoryInterface;

class StoreRepository implements StoreRepositoryInterface
{
    public function create(array $data): Store
    {
        return Store::create($data);
    }

    public function update(Store $store, array $data): Store
    {
        $store->update($data);
        return $store;
    }

    public function delete(Store $store): void
    {
        $store->delete();
    }

    public function getAll(): array
    {
        return Store::all()->toArray();
    }

    public function getByUser(int $userId): array
    {
        return Store::where('user_id', $userId)->get()->toArray();
    }
}
