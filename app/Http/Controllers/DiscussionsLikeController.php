<?php

namespace App\Http\Controllers;

use App\Models\DiscussionsLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionsLikeController extends Controller
{
    public function store(Request $request)
    {
        $discussionLike = DiscussionsLike::create($request->all());
        return response()->json($discussionLike, 200);
    }

    public function showDiscussionLike(string $likedDiscussionId)
    {
        $followedUser = DiscussionsLike::where("user_id", Auth::user()->id)->where("discussion_id", $likedDiscussionId)->first();
        if ($followedUser) return response()->json($followedUser, 200);
        return response()->json(false, 200);
    }

    public function destroy(string $discussionId)
    {
        $discussionLike = DiscussionsLike::where("user_id", Auth::user()->id)->where("discussion_id", $discussionId)->first();
        $discussionLike->delete();
        return response()->json($discussionLike, 200);
    }
}
