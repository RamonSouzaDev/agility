<?php

namespace App\Services;

use App\Models\Store;
use App\Repositories\Contracts\StoreRepositoryInterface;
use App\Services\Contracts\StoreServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StoreService implements StoreServiceInterface
{
    private $storeRepository;

    public function __construct(StoreRepositoryInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    public function create(array $data): Store
    {
        $this->validateStoreData($data);

        $data = $this->fetchAdditionalStoreData($data['cep'], $data);

        $user = Auth::user();
        $data['user_id'] = $user->id;

        return $this->storeRepository->create($data);
    }

    public function update(Store $store, array $data): Store
    {
        $this->validateStoreData($data);

        $data = $this->fetchAdditionalStoreData($data['cep'], $data);

        $user = Auth::user();
        if ($store->user_id !== $user->id) {
            throw new \Exception('Unauthorized');
        }

        return $this->storeRepository->update($store, $data);
    }

    public function delete(Store $store): void
    {
        $user = Auth::user();
        if ($store->user_id !== $user->id) {
            throw new \Exception('Unauthorized');
        }

        $this->storeRepository->delete($store);
    }

    public function getAll(): array
    {
        return $this->storeRepository->getAll();
    }

    public function getByUser(int $userId): array
    {
        return $this->storeRepository->getByUser($userId);
    }

    private function validateStoreData(array $data): void
    {
        $validationRules = [
            'name' => 'required',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($data, $validationRules);

        if ($validator->fails()) {
            throw new \Exception('Invalid store data');
        }
    }

    private function fetchAdditionalStoreData(string $cep, array $data): array
    {
        $cep = str_replace('-', '', $cep);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        $dataViaCep = $response->json();

        if (isset($dataViaCep['erro'])) {
            throw new \Exception('Invalid CEP');
        }

        $data['street'] = $dataViaCep['logradouro'];
        $data['neighborhood'] = $dataViaCep['bairro'];
        $data['city'] = $dataViaCep['localidade'];

        return $data;
    }
}
