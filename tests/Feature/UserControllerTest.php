<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\API\UserController;
use App\Services\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\WithFaker; 

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testRegister()
    {
        // Crie um usuário fictício usando o modelo factory
        $user = User::factory()->create([
            'name' => 'Ramon Mendes Developer',
            'email' => 'dwmom@hotmail.com',
            'password' => bcrypt('password123'),
        ]);

        // Mock do UserServiceInterface
        $userService = $this->createMock(UserServiceInterface::class);

        $userService->expects($this->once())
            ->method('register')
            ->with($user->toArray()) // Use os dados do usuário fictício
            ->willReturn($user);

        $controller = new UserController($userService);

        $request = Request::create('/register', 'POST', $user->toArray()); // Use os dados do usuário fictício

        $response = $controller->register($request);

        $responseData = json_decode($response->getContent(), true);

        $this->assertEquals(201, $response->getStatusCode());

        $expectedData = [
            'name' => 'Ramon Mendes Developer',
            'email' => 'dwmom@hotmail.com',
        ];

        $userResponse = $responseData['user'];

        $this->assertEquals('User registered successfully', $responseData['message']);
        $this->assertEquals($expectedData['name'], $userResponse['name']);
        $this->assertEquals($expectedData['email'], $userResponse['email']);
    }

    public function testLogin()
    {
        // Crie um usuário fictício usando o modelo factory
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    
        $credentials = [
            'email' => 'test@example.com',
            'password' => 'password123',
        ];
    
        // Mock do Auth facade
        $this->app->bind('auth', function ($app) use ($credentials, $user) {
            $authMock = $this->createMock('Illuminate\Contracts\Auth\Factory');
    
            $authMock->expects($this->once())
                ->method('attempt')
                ->with($credentials)
                ->willReturn(true);
    
            $authMock->shouldReceive('user')
                ->andReturn($user);
    
            return $authMock;
        });
    
        // Inicialize o controlador UserController com a dependência UserServiceInterface
        $userService = $this->createMock(UserServiceInterface::class);
        $controller = new UserController($userService);
    
        // Criar uma instância da classe Request com os dados de credenciais
        $request = Request::create('/login', 'POST', $credentials);
    
        $response = $controller->login($request);

        $responseData = json_decode($response->getContent(), true);
    
        $this->assertEquals(200, $response->getStatusCode());
    }

}

