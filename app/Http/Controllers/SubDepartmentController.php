<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subdepartment;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class SubDepartmentController extends Controller
{
    public function index()
    {
        return subdepartment::select('id', 'id_department', 'name')->get();
    }

    public function show($id)
    {
        $subdepartment = SubDepartment::where('id', $id)->first();
        return response()->json([
            'subdepartment' => $subdepartment
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $subdepartment = new subdepartment;
        $subdepartment->fill($request->post());
        $subdepartment->save();

        return response()->json([
            'message' => 'Dodano nowy pod dział'
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);


        Subdepartment::where('id', $id)->update([
            'name' => $request->name
        ]);


        return response()->json([
            'message' => 'Zmieniono nazwę poddziału'
        ]);
    }


    public function destroy(Subdepartment $subdepartment)
    {
        $subdepartment->delete();
        return response()->json([
            'message' => 'Dział pod dział'
        ]);
    }
    public function show_subdepartment($id)
    {
        $subdepartment = Subdepartment::where('id', $id)->first();
        $categories = Category::where('id_subdepartment', $id)->get();
        $data = [
            'name' => $subdepartment->name,
            'id_subdepartment' => $subdepartment->id,
            'categories' => $categories
        ];

        return response()->json([
            'subdepartment' => $data
        ]);
    }
}
