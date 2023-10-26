<?php

namespace App\Http\Controllers;

use App\Models\FollowedUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowedUserController extends Controller
{
    public function index()
    {
        return FollowedUser::all();
    }

    public function store(Request $request)
    {
        $followedUser = FollowedUser::create($request->all());
        return response()->json($followedUser, 200);
    }

    public function show(string $id)
    {
        return FollowedUser::findOrFail($id);
    }

    public function showFollowedUser(string $followedUserId)
    {
        $followedUser = FollowedUser::where("user_id", Auth::user()->id)->where("followed_user_id", $followedUserId)->first();
        if ($followedUser) return response()->json($followedUser, 200);
        return response()->json(false, 200);
    }

    public function update(Request $request, string $id)
    {
        $followedUser = FollowedUser::findOrFail($id);
        $followedUser->update($request->all());
    }

    public function destroy(string $followedUserId)
    {
        $followedUser = FollowedUser::where("user_id", Auth::user()->id)->where("followed_user_id", $followedUserId)->first();
        if ($followedUser) {
            $followedUser->delete();
            return response()->json($followedUser, 200);
        }
        return response()->json(false, 200);
    }
}
