<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\SignInRequest;
use App\Http\Requests\UserRequests\SignUpRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showSignin()
    {
        return view('signin');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function showSignup()
    {
        return view('signup');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function signup(SignUpRequest $request, UserService $userService)
    {
        try {
            DB::beginTransaction();
            $user = $userService->storeUser($request);
            if ($user) {
                DB::commit();
                $userService->authAfterSignup($user);
                return to_route('home');
            } else {
                DB::rollBack();
                return back()->withInput()->withErrors('Unknown error, please try again !');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return throw $e;
        }
    }

    public function authenticate(SignInRequest $request, UserService $userService)
    {
        try {
            DB::beginTransaction();
            if ($userService->authenticate($request)) {
                $userService->generateSession($request);
                DB::commit();
                return redirect()->intended(route('home'));
            } else {
                DB::rollBack();
                return back()->withInput()->withErrors('Login failed, email or password not correct !');
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            return throw $e;
        }
    }

    public function logout(Request $request, UserService $userService)
    {
        $userService->logout($request);
        return to_route('home');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
