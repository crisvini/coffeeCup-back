<?php

namespace App\Http\Controllers;

use App\Models\AnswersLike;
use Illuminate\Http\Request;

class AnswersLikeController extends Controller
{
    public function index()
    {
        return AnswersLike::all();
    }

    public function store(Request $request)
    {
        AnswersLike::create($request->all());
    }

    public function show(string $id)
    {
        return AnswersLike::findOrFail($id);
    }

    public function update(Request $request, string $id)
    {
        $user = AnswersLike::findOrFail($id);
        $user->update($request->all());
    }

    public function destroy(string $id)
    {
        $user = AnswersLike::findOrFail($id);
        $user->delete();
    }
}
