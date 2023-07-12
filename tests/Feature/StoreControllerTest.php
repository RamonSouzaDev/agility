<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\API\StoreController;
use App\Services\Contracts\StoreServiceInterface;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User;


class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStore()
    {
        // Criar uma loja fictícia para o teste
        $storeData = [
            'name' => 'Loja do Ramon',
            'cep' => '12345-678',
            'street' => 'Rua A',
            'neighborhood' => 'Bairro',
            'city' => 'Guarulhos',
        ];

        $storeService = $this->createMock(StoreServiceInterface::class);

        $storeService->expects($this->once())
            ->method('create')
            ->with($storeData)
            ->willReturn(new Store($storeData));

        $controller = new StoreController($storeService);

        $request = Request::create('/store', 'POST', $storeData);

        $user = new User();
        Auth::shouldReceive('user')->andReturn($user);

        $response = $controller->store($request);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());

        $expectedData = [
            'name' => 'Loja do Ramon',
            'cep' => '12345-678',
            'street' => 'Rua A',
            'neighborhood' => 'Bairro',
            'city' => 'Guarulhos',
        ];

        $this->assertEquals('Store created successfully', $responseData['message']);
        $this->assertEquals($expectedData, $responseData['store']);
    }

    public function testUpdate()
    {
        // Criar uma loja fictícia para o teste
        $storeData = [
            'name' => 'Loja do Ramon',
            'cep' => '12345-678',
            'street' => 'Rua A',
            'neighborhood' => 'Bairro',
            'city' => 'Guarulhos',
        ];

        // Mock do StoreServiceInterface
        $storeService = $this->createMock(StoreServiceInterface::class);

        $storeService->expects($this->once())
            ->method('update')
            ->willReturn(new Store($storeData));

        $controller = new StoreController($storeService);

        $store = new Store($storeData);

        $request = Request::create('/store/1', 'PUT', $storeData);

        $response = $controller->update($request, $store);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());

        $expectedData = [
            'name' => 'Loja do Ramon',
            'cep' => '12345-678',
            'street' => 'Rua A',
            'neighborhood' => 'Bairro',
            'city' => 'Guarulhos',
        ];

        $this->assertEquals('Store updated successfully', $responseData['message']);
        $this->assertEquals($expectedData, $responseData['store']);
    }
}
