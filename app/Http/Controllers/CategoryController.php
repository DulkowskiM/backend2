<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subdepartment;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoryController extends Controller

{
    public function index()
    {
        return Category::select('id', 'id_subdepartment', 'name')->paginate(10);
    }
    public function show($id)
    {
        $category = Category::where('id', $id)->first();
        return response()->json([
            'category' => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);


        Category::where('id', $id)->update([
            'name' => $request->name
        ]);


        return response()->json([
            'message' => 'Zmieniono nazwę kategorii'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $category = new Category;
        $category->fill($request->post());
        $category->save();

        return response()->json([
            'message' => 'Dodano nową  kategorię'
        ]);
    }
    public function changeStatus(Request $request, Topic $topic)
    {
        $request->validate([
            'is_open' => 'required|int',
        ]);

        $topic->is_open = $request->is_open;
        $topic->save();

        return response()->json([
            'message' => 'Zmieniono status tematu'
        ]);
    }


    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Kategoria usunięta'
        ]);
    }
    public function show_category($id)
    {
        $category = Category::where('id', $id)->first();
        $topics = Topic::where('id_category', $id)->paginate(10);
        $data = [
            'name' => $category->name,
            'id_category' => $category->id,
            'topics' => $topics
        ];

        return response()->json([
            'category' => $data
        ]);
    }
}
