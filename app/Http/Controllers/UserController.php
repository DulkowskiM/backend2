<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return User::select('id', 'name', 'created_at')->paginate(10);
    }
    public function show(User $user)
    {
        return response()->json([
            'user' => $user
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $user->fill($request->post())->update();


        return response()->json([
            'message' => 'Zmieniono nazwę użytkownika'
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json([
            'message' => 'Użytkownik usunięty'
        ]);
    }
    public function my_profile()
    {
        $id_user = Auth::id();
        if ($id_user === null) {
            return response()->json(['error' => 'User not authenticated']);
        }
        $user = User::find($id_user);
        if ($user === null) {
            return response()->json(['error' => 'User not found']);
        }
        $posts = Post::where('id_user', $user->id)->get();
        $topics = Topic::where('id_user', $user->id)->get();

        return response()->json([
            'user' => $user,
            'posts' => $posts,
            'topics' => $topics
        ]);
    }


    public function changeAdminStatus(Request $request, User $user)
    {
        $request->validate([
            'is_admin' => 'required|int',
        ]);

        $user->is_admin = $request->is_admin;
        $user->save();

        return response()->json([
            'message' => 'Zmieniono uprawnienia użytkownika'
        ]);
    }

    public function show_profile($id_user)
    {
        $user = User::find($id_user);
        $posts = Post::where('id_user', $user->id)->get();
        $topics = Topic::where('id_user', $user->id)->get();

        return response()->json([
            'user' => $user,
            'posts' => $posts,
            'topics' => $topics
        ]);
    }
    public function index2()
    {
        return User::select('id', 'name', 'created_at');
    }
}
