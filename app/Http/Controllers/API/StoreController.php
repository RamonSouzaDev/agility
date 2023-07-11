<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
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

        // Criar a loja
        $store = Store::create([
            'name' => $request->name,
            'cep' => $request->cep,
            'street' => $data['logradouro'],
            'neighborhood' => $data['bairro'],
            'city' => $data['localidade'],
        ]);

        return response()->json(['message' => 'Store created successfully', 'store' => $store], 201);
    }
}
