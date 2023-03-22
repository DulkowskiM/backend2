<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;


class TopicController extends Controller
{
    public function index()
    {
        return Topic::select('id', 'id_category', 'id_user',  'name', 'content', 'is_open')->paginate(10);
    }
    public function show(Topic $topic)
    {
        return response()->json([
            'topic' => $topic
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_category' => 'required',
            'id_user' => 'required',
            'name' => 'required',
            'content' => 'required',
        ]);
        $topic = new topic;
        $topic->fill($request->post());
        $topic->save();
        return response()->json([
            'message' => 'Dodano nowy dział'
        ]);
    }
    public function update(Request $request, Topic $topic)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
        ]);

        $topic->fill($request->post())->update();


        return response()->json([
            'message' => 'Nowy temat został pomyślnie utworzony'
        ]);
    }

    public function destroy(Topic $topic)
    {
        $topic->delete();
        return response()->json([
            'message' => 'Temat usunięty'
        ]);
    }

    public function show_topic($id_topic)
    {
        $topic = Topic::with(['user', 'posts.user'])
            ->where('id', $id_topic)
            ->firstOrFail();

        $posts = Post::where('id_topic', $topic->id)
            ->paginate(10);



        return response()->json([
            'Topic' => [
                'id' => $topic->id,
                'name' => $topic->name,
                'content' => $topic->content,
                'created_at' => $topic->created_at,
                'id_user' => $topic->user->id,
                'name_user' => $topic->user->name,
                'is_open' => $topic->is_open,
            ],
            'Posts' => $posts->map(function ($post) {
                return [
                    'id_post' => $post->id,
                    'content' => $post->content,
                    'created_at' => $post->created_at,
                    'id_user' => $post->user->id,
                    'name_user' => $post->user->name,
                ];
            }),
            'pagination' => [
                'total' => $posts->total(),
                'per_page' => $posts->perPage(),
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'next_page_url' => $posts->nextPageUrl(),
                'prev_page_url' => $posts->previousPageUrl(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ],
        ]);
    }

    public function changeStatus(Request $request, Topic $topic)
    {
        $request->validate([
            'is_open' => 'required|int',
        ]);

        $topic->fill([
            'is_open' => $request->input('is_open')
        ])->save();

        return response()->json([
            'message' => 'Zmieniono status tematu'
        ]);
    }
}
