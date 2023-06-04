<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if (!Auth::guard("users")->attempt($request->only('email', 'password'))) {
            return \response([
                'error' => 'Invalid Credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user  */
        $user = Auth::guard("users")->user();
        $token = $user->createToken('token')->plainTextToken;

        return \response([
            'jwt' => $token
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');
        $user = Auth::user()->tokens()->delete();
        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
