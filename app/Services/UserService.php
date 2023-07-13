<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

class UserService implements UserServiceInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data): User
    {
        $this->validateRegistrationData($data);

        $user = $this->userRepository->create($data);

        //Mail::to($user->email)->send(new WelcomeEmail());

        return $user;
    }

    public function login(array $credentials): array
    {
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;
            
            return [
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ];
        } else {
            throw new \Exception('Invalid credentials');
        }
    }

    public function logout(User $user): void
    {
        $user->tokens()->delete();
    }

    private function validateRegistrationData(array $data): void
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($data, $validationRules);

        if ($validator->fails()) {
            throw new \Exception('Invalid registration data');
        }
    }
}
