<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Auth;


class DiscussionController extends Controller
{
    // public function index()
    // {
    //     return response()->json(Discussion::with('user:id,name,email')->orderBy('created_at', 'desc')->get(), 200);
    // }

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
        // $user = User::select('users.id', 'users.name', 'users.email', 'users.created_at')
        //     ->leftJoin('discussions', 'users.id', '=', 'discussions.user_id')
        //     ->leftJoin('discussions_likes', 'users.id', '=', 'discussions_likes.user_id')
        //     ->leftJoin('discussions_answers', 'users.id', '=', 'discussions_answers.user_id')
        //     ->leftJoin('answers_likes', 'users.id', '=', 'answers_likes.user_id')
        //     ->leftJoin('followed_users', 'users.id', '=', 'followed_users.followed_user_id')
        //     ->selectRaw('users.id, users.name, users.email, users.created_at,
        //          COUNT(distinct discussions.id) as discussions_count,
        //          COUNT(distinct discussions_likes.id) as discussions_likes_count,
        //          COUNT(distinct discussions_answers.id) as discussions_answers_count,
        //          COUNT(distinct answers_likes.id) as answers_likes_count,
        //          COUNT(distinct followed_users.id) as followers_count')
        //     ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at')
        //     ->findOrFail($id);

        // $discussion = Discussion::with('user:id,name,email')
        //     ->leftJoin('discussions_likes', 'discussions.id', '=', 'discussions_likes.discussion_id')
        //     ->select('discussions.*', 'users.name', 'users.email', 'users.created_at')
        //     ->where('discussions.id', $id)
        //     ->first();

        $discussion = Discussion::select('discussions.*')
        ->addSelect(DB::raw('(SELECT COUNT(DISTINCT user_id) FROM discussions_likes WHERE discussion_id = discussions.id) as discussions_likes_count'))
        ->join('users', 'discussions.user_id', '=', 'users.id')
        ->where('discussions.id', 150)
        ->first();



        return response()->json($discussion, 200);
    }

    // public function update(Request $request, string $id)
    // {
    //     $discussion = Discussion::findOrFail($id);
    //     $discussion->update($request->all());
    // }

    public function destroy(string $id)
    {
        $discussion = Discussion::findOrFail($id);
        $discussion->answers()->delete();
        $discussion->delete();
        return response()->json(true, 200);
    }
}
