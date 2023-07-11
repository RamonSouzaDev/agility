<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class StoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/',
        ]);

        // Obter dados do CEP via API ViaCEP
        $cep = str_replace('-', '', $request->cep);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        $data = $response->json();

        // Verificar se o CEP é válido
        if (isset($data['erro'])) {
            return response()->json(['message' => 'Invalid CEP'], 422);
        }

        // Criar a loja associada ao usuário logado
        $user = Auth::user();
        $store = $user->stores()->create([
            'name' => $request->name,
            'cep' => $request->cep,
            'street' => $data['logradouro'],
            'neighborhood' => $data['bairro'],
            'city' => $data['localidade'],
        ]);

        return response()->json(['message' => 'Store created successfully', 'store' => $store], 201);
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required',
            'cep' => 'required|regex:/^\d{5}-\d{3}$/',
        ]);

        $cep = str_replace('-', '', $request->cep);
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");
        $data = $response->json();

        if (isset($data['erro'])) {
            return response()->json(['message' => 'Invalid CEP'], 422);
        }

        // Verificar se o usuário logado é o proprietário da loja
        $user = Auth::user();
        if ($store->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Atualizar os dados da loja
        $store->update([
            'name' => $request->name,
            'cep' => $request->cep,
            'street' => $data['logradouro'],
            'neighborhood' => $data['bairro'],
            'city' => $data['localidade'],
        ]);

        return response()->json(['message' => 'Store updated successfully', 'store' => $store], 200);
    }

    public function destroy(Request $request, Store $store)
    {
        // Verificar se o usuário logado é o proprietário da loja
        $user = Auth::user();
        if ($store->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Excluir a loja
        $store->delete();

        return response()->json(['message' => 'Store deleted successfully'], 200);
    }

    public function index(Request $request)
    {
        $stores = Store::all();

        return response()->json(['stores' => $stores], 200);
    }

    public function userStores(Request $request)
    {
        $user = Auth::user();
        $stores = $user->stores;

        return response()->json(['stores' => $stores], 200);
    }
}
