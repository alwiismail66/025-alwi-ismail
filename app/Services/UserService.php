<?php

namespace  App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(protected UserRepository $repo)
    {
    }
    public function storeUser(FormRequest $request): bool|User
    {
        $request = $request->safe();
        return $this->repo->storeUser($request);
    }

    public function authAfterSignup(User $user): void
    {
        Auth::login($user);
    }
    public function authenticate(FormRequest $request)
    {
        $request = $request->safe();
        return Auth::attempt($request->toArray());
    }

    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
    public function generateSession($request): bool
    {
        return $request->session()->regenerate();
    }
}
