<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class DiscussionController extends Controller
{
    public function index()
    {
        return Discussion::with('user:id,name,email')->get();
    }

    public function store(Request $request)
    {
        try {
            $discussion = Discussion::create($request->all());
        } catch (Exception  $e) {
            return false;
        }
        return response()->json($discussion, 200);
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
