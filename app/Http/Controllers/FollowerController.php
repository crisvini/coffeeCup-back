<?php

namespace App\Http\Controllers;

use App\Models\Follower;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function index()
    {
        return Follower::all();
    }

    public function store(Request $request)
    {
        Follower::create($request->all());
    }

    public function show(string $id)
    {
        return Follower::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = Follower::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = Follower::findOrFail($id);
        $user->delete();
    }
}
