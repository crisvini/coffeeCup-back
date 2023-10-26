<?php

namespace App\Http\Controllers;

use App\Models\DiscussionsAnswer;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class DiscussionsAnswerController extends Controller
{
    // public function index()
    // {
    //     return response()->json(DiscussionsAnswer::with('user:id,name,email')->orderBy('created_at', 'desc')->get(), 200);
    // }

    public function indexFiltered(string $discussionId)
    {
        return response()->json(DiscussionsAnswer::with('user:id,name,email')->where('discussion_id', $discussionId)->orderBy('created_at', 'desc')->get(), 200);
    }

    public function store(Request $request)
    {
        try {
            $answer = DiscussionsAnswer::create($request->all());
            $answer->load('user:id,name,email');
        } catch (Exception  $e) {
            return false;
        }
        return response()->json($answer, 200);
    }

    // public function show(string $id)
    // {
    //     return response()->json(DiscussionsAnswer::with('user:id,name,email')->findOrFail($id), 200);
    // }

    // public function update(Request $request, string $id)
    // {
    //     $discussionAnswer = DiscussionsAnswer::findOrFail($id);
    //     $discussionAnswer->update($request->all());
    // }

    // public function destroy(string $id)
    // {
    //     $discussionAnswer = DiscussionsAnswer::findOrFail($id);
    //     $discussionAnswer->delete();
    // }
}
