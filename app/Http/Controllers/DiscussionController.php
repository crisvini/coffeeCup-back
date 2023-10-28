<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Auth;


class DiscussionController extends Controller
{
    public function indexFiltered(string $filterId)
    {
        if ($filterId == 1) {
            return response()->json(Discussion::with('user:id,name,email')->orderBy('created_at', 'desc')->paginate(10), 200);
        } else if ($filterId == 2) {
            return
                response()->json(Discussion::select('discussions.*')
                    ->join('followed_users', 'followed_users.followed_user_id', '=', 'discussions.user_id')
                    ->where('followed_users.user_id', Auth::user()->id)
                    ->with('user:id,name,email')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10), 200);
        } else if ($filterId == 3) {
            return response()->json(Discussion::with('user:id,name,email')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10), 200);
        }
    }

    public function indexFilteredByUser(string $userId)
    {
        return response()->json(Discussion::with('user:id,name,email')->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(10), 200);
    }

    public function store(Request $request)
    {
        try {
            $discussion = Discussion::create($request->all());
            $discussion->load('user:id,name,email');
        } catch (Exception  $e) {
            return response()->json(false, 404);
        }
        return response()->json($discussion, 200);
    }

    public function show(string $id)
    {
        $discussion = Discussion::select('discussions.*')
            ->addSelect(DB::raw('(SELECT COUNT(DISTINCT user_id) FROM discussions_likes WHERE discussion_id = discussions.id) as discussions_likes_count'))
            ->join('users', 'discussions.user_id', '=', 'users.id')
            ->where('discussions.id', $id)
            ->first();

        return response()->json($discussion, 200);
    }

    public function destroy(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        $discussion->answers()->delete();
        $discussion->delete();
        return response()->json(true, 200);
    }
}
