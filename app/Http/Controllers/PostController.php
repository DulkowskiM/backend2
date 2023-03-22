<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return Post::select('id_post', 'id_topic', 'id_user',  'content')->get();
    }
    public function show(Post $post)
    {
        return response()->json([
            'topic' => $post
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_topic' => 'required',
            'content' => 'required',
        ]);
        $post = new Post;
        $post->fill($request->post());
        $post->save();

        return response()->json([
            'message' => 'Dodano odpowiedź do tematu'
        ]);
    }
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post->fill($request->post())->update();


        return response()->json([
            'message' => 'Zaktualizowano odpowiedź'
        ]);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            'message' => 'Odpowiedź usunięty'
        ]);
    }
}
