<?php

namespace App\Http\Controllers\Dashboard;

use App\DTOs\Dashboard\Auth\SignInDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\SignInFormRequest;
use App\Services\Dashboard\AuthService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){
    }

    public function showSignIn(): View
    {
        return view('dashboard.auth.signin');
    }

    public function signIn(SignInFormRequest $request): RedirectResponse
    {
        $serviceResponse = $this->authService->signIn(SignInDTO::fromRequest($request));

        if ($serviceResponse->error) {
            return redirect()->route('auth.show-sign-in')->withErrors([$serviceResponse->column => $serviceResponse->message]);
        }

        return redirect()->route('home')->with($serviceResponse->data);
    }

    public function logout(): RedirectResponse
    {
        $serviceResponse = $this->authService->logout();

        return redirect()->route('auth.show-sign-in')->with($serviceResponse->data);
    }
}
