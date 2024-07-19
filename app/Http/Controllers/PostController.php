<?php

namespace App\Http\Controllers;

use App\DTOs\PostDTO;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all()->map(function ($post) {
            return PostDTO::fromModel($post);
        });
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json(PostDTO::fromModel($post));
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());
        return response()->json(PostDTO::fromModel($post), 201);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json(PostDTO::fromModel($post), 200);
    }

    public function destroy($id)
    {
        Post::destroy($id);
        return response()->json(null, 204);
    }

    public function getUserPosts($userId)
    {
        $user = User::with('posts')->findOrFail($userId);
        $posts = $user->posts->map(function ($post) {
            return PostDTO::fromModel($post);
        });

        return response()->json($posts);
    }
}
