<?php

namespace App\Http\Controllers;

use App\Models\DiscussionsLike;
use Illuminate\Http\Request;

class DiscussionsLikeController extends Controller
{
    public function index()
    {
        return DiscussionsLike::all();
    }

    public function store(Request $request)
    {
        DiscussionsLike::create($request->all());
    }

    public function show(string $id)
    {
        return DiscussionsLike::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = DiscussionsLike::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = DiscussionsLike::findOrFail($id);
        $user->delete();
    }
}
