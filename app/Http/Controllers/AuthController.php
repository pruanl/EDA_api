<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'user_type' => 'required|integer|between:1,4'
        ]);

        //verifica se o usuário logado tem permissão para criar usuários, apenas usuários com a role de admin podem criar usuários
        if (!Auth::user()->hasRole('admin') && $request->user_type == 1) {
            return response(['message' => 'Você não tem permissão para criar usuários administradores']);
        }

        //verifica se o usuário logado tem permissão para criar usuários, apenas usuários com a role de admin ou secretaria podem criar usuários secretaria

        if (!Auth::user()->hasRole('admin') && !Auth::user()->hasRole('diretor') && $request->user_type == 2) {
            return response(['message' => 'Você não tem permissão para criar usuários secretaria']);
        }

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return response([ 'user' => $user, 'role' => $user->getRoleNames()[0], 'access_token' => $accessToken]);
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = Auth::user()->createToken('authToken')->plainTextToken;

        return response(['user' => Auth::user(), 'access_token' => $accessToken]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        $response = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()[0]
        ];

        return response($response);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response(['message' => 'Logged out']);
    }
}
