<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index()
    {
        return Discussion::all();
    }

    public function store(Request $request)
    {
        Discussion::create($request->all());
    }

    public function show(string $id)
    {
        return Discussion::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = Discussion::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = Discussion::findOrFail($id);
        $user->delete();
    }
}
