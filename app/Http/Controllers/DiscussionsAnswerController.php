<?php

namespace App\Http\Controllers;

use App\Models\DiscussionsAnswer;
use Illuminate\Http\Request;

class DiscussionsAnswerController extends Controller
{
    public function index()
    {
        return DiscussionsAnswer::all();
    }

    public function store(Request $request)
    {
        DiscussionsAnswer::create($request->all());
    }

    public function show(string $id)
    {
        return DiscussionsAnswer::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = DiscussionsAnswer::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = DiscussionsAnswer::findOrFail($id);
        $user->delete();
    }
}
