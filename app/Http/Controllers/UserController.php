<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;

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

    public function sendVerificationToken(Request $request)
    {
        $token = mt_rand(100000, 999999);
        $sent = Mail::to($request->input('email'))->send(new EmailVerification([
            'fromName' => 'Coffee Cup',
            'fromEmail' => 'coffeecup@verification.com',
            'subject' => 'Your verification token from Coffee Cup',
            'message' => ('Your verification token is ' . $token)
        ]));
        return $token;
    }

    public function receiveVerificationToken(string $id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();
        return true;
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
            return response()->json($token->plainTextToken, 200);
        }
        return response()->json(false, 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(true, 200);
    }
}
