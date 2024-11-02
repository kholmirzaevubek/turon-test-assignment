<?php

namespace App\Services\Dashboard;

use App\DTOs\Dashboard\Auth\SignInDTO;
use App\DTOs\ServiceResponseDTO;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function __construct(
        private readonly ResponseService $responseService
    ){
    }

    public function signIn(SignInDTO $dto): ServiceResponseDTO
    {
        // Retrieve the user by username from the database
        $user = User::where('username', '=', $dto->username)->first();

        // Check if the user exists; if not, return an error response indicating the username is invalid
        if (! $user) {
            return $this->responseService->failureResponse(message: 'username is not valid', column: 'username');
        }

        // Verify the provided password against the stored password hash
        if (! Hash::check($dto->password, $user->password)) {
            return $this->responseService->failureResponse(message: 'password is not valid', column: 'password');
        }

        // Log the user into the application
        Auth::login($user);

        return $this->responseService->successResponse(data: [
            'message' => 'signin'
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return $this->responseService->successResponse(data: [
            'message' => 'logout'
        ]);
    }
}
