<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Mockery\CountValidator\Exception;

class DiscussionController extends Controller
{
    public function index()
    {
        return Discussion::all();
    }

    public function store(Request $request)
    {
        try {
            Discussion::create($request->all());
        } catch (Exception  $e) {
            return false;
        }
        return true;
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
