<?php

namespace App\Http\Controllers;

use App\Models\FollowedUser;
use Illuminate\Http\Request;

class FollowedUserController extends Controller
{
    public function index()
    {
        return FollowedUser::all();
    }

    public function store(Request $request)
    {
        FollowedUser::create($request->all());
    }

    public function show(string $id)
    {
        return FollowedUser::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = FollowedUser::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = FollowedUser::findOrFail($id);
        $user->delete();
    }
}
