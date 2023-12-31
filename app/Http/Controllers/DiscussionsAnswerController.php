<?php

namespace App\Http\Controllers;

use App\Models\DiscussionsAnswer;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class DiscussionsAnswerController extends Controller
{

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
}
