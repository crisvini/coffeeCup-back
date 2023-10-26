<?php

namespace App\Http\Controllers;

use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->leftJoin('discussions', 'users.id', '=', 'discussions.user_id')
            ->leftJoin('discussions_likes', 'users.id', '=', 'discussions_likes.user_id')
            ->leftJoin('discussions_answers', 'users.id', '=', 'discussions_answers.user_id')
            ->leftJoin('answers_likes', 'users.id', '=', 'answers_likes.user_id')
            ->leftJoin('followed_users', 'users.id', '=', 'followed_users.followed_user_id')
            ->selectRaw('users.id, users.name, users.email, users.created_at,
                     COUNT(distinct discussions.id) as discussions_count,
                     COUNT(distinct discussions_likes.id) as discussions_likes_count,
                     COUNT(distinct discussions_answers.id) as discussions_answers_count,
                     COUNT(distinct answers_likes.id) as answers_likes_count,
                 COUNT(distinct followed_users.id) as followers_count')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->get();

        $users->each(function ($user) {
            $interactions = $user->discussions_count + $user->discussions_likes_count + $user->discussions_answers_count + $user->answers_likes_count;
            $user->interactions = $interactions;
        });

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json(['id' => $user->id], 200);
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
        $user = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
            ->leftJoin('discussions', 'users.id', '=', 'discussions.user_id')
            ->leftJoin('discussions_likes', 'users.id', '=', 'discussions_likes.user_id')
            ->leftJoin('discussions_answers', 'users.id', '=', 'discussions_answers.user_id')
            ->leftJoin('answers_likes', 'users.id', '=', 'answers_likes.user_id')
            ->leftJoin('followed_users', 'users.id', '=', 'followed_users.followed_user_id')
            ->selectRaw('users.id, users.name, users.email, users.created_at,
                 COUNT(distinct discussions.id) as discussions_count,
                 COUNT(distinct discussions_likes.id) as discussions_likes_count,
                 COUNT(distinct discussions_answers.id) as discussions_answers_count,
                 COUNT(distinct answers_likes.id) as answers_likes_count,
                 COUNT(distinct followed_users.id) as followers_count')
            ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
            ->findOrFail($id);

        if ($user) {
            $interactions = $user->discussions_count + $user->discussions_likes_count + $user->discussions_answers_count + $user->answers_likes_count;
            $user->interactions = $interactions;
        }

        return response()->json($user, 200);
    }

    // public function update(Request $request, string $id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->update($request->all());
    // }

    // public function destroy(string $id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();
    // }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user->email_verified_at) {
            return response()->json(["error" => "email not validated", "user_id" => $user->id], 200);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('JWT');
            return response()->json(["token" => $token->plainTextToken, "user_id" => $user->id, "email" => $user->email], 200);
        }
        return response()->json(false, 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(true, 200);
    }
}
