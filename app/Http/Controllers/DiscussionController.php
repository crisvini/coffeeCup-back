<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Auth;


class DiscussionController extends Controller
{
    public function index()
    {
        return Discussion::with('user:id,name,email')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function indexFiltered(string $filterId)
    {
        if ($filterId == 1) {
            return Discussion::with('user:id,name,email')->orderBy('created_at', 'desc')->paginate(10);
        } else if ($filterId == 2) {
            return
                Discussion::select('discussions.*')
                ->join('followed_users', 'followed_users.followed_user_id', '=', 'discussions.user_id')
                ->where('followed_users.user_id', Auth::user()->id)
                ->with('user:id,name,email')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else if ($filterId == 3) {
            return Discussion::with('user:id,name,email')->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        }
    }

    public function store(Request $request)
    {
        try {
            $discussion = Discussion::create($request->all());
            $discussion->load('user:id,name,email');
        } catch (Exception  $e) {
            return false;
        }
        return response()->json($discussion, 200);
    }

    public function show(string $id)
    {
        return Discussion::with('user:id,name,email')->findOrFail($id);
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
