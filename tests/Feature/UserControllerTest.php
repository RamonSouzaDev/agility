<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\API\UserController;
use App\Services\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        // Criar um usuário fictício para o teste
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
        ];

        // Mock do UserServiceInterface
        $userService = $this->createMock(UserServiceInterface::class);

        $userService->expects($this->once())
            ->method('register')
            ->with($userData)
            ->willReturn(new User($userData));

        $controller = new UserController($userService);

        $request = Request::create('/register', 'POST', $userData);

        $response = $controller->register($request);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());

        $expectedData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ];

        $this->assertEquals('User registered successfully', $responseData['message']);
        $this->assertEquals($expectedData, $responseData['user']);
    }
}

