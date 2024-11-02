<?php

namespace App\DTOs\Dashboard\Auth;

use App\Http\Requests\Dashboard\Auth\SignInFormRequest;

final class SignInDTO
{
    public function __construct(
        public readonly string $username,
        public readonly string $password
    ){
    }

    public static function fromRequest(SignInFormRequest $request): self
    {
        return new self (
            username: $request->input('username'),
            password: $request->input('password')
        );
    }
}
