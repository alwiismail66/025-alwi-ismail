<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function storeUser($request)
    {
        return User::create([
            'email' => $request->email,
            'name' => $request->name,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password)
        ]);
    }
}
