<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Contracts\StoreServiceInterface;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class StoreController extends Controller
{
    private $storeService;

    public function __construct(StoreServiceInterface $storeService)
    {
        $this->storeService = $storeService;
    }

    public function store(Request $request)
    {
        try {
            $store = $this->storeService->create($request->all());
            return response()->json(['message' => 'Store created successfully', 'store' => $store], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function update(Request $request, Store $store)
    {
        try {
            $store = $this->storeService->update($store, $request->all());
            return response()->json(['message' => 'Store updated successfully', 'store' => $store], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function destroy(Request $request, Store $store)
    {
        try {
            $this->storeService->delete($store);
            return response()->json(['message' => 'Store deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function index(Request $request)
    {
        $stores = $this->storeService->getAll();
        return response()->json(['stores' => $stores], 200);
    }

    public function userStores(Request $request)
    {
        $user = Auth::user();
        $stores = $this->storeService->getByUser($user->id);
        return response()->json(['stores' => $stores], 200);
    }
}
