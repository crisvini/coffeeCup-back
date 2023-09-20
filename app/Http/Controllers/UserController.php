<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        User::create($request->all());
    }

    public function show(string $id)
    {
        return User::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('JWT');
            return response()->json($token, 200);
        }
        return response()->json('Usuário inválido', 401);
    }
}
