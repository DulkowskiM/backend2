<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Department;
use App\Models\Subdepartment;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return Department::select('id',  'name')->get();
    }

    public function show($id)
    {
        $department = Department::where('id', $id)->first();
        return response()->json([
            'department' => $department
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $department = new Department;
        $department->fill($request->post());
        $department->save();

        return response()->json([
            'message' => 'Dodano nowy dział'
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);


        Department::where('id', $id)->update([
            'name' => $request->name
        ]);


        return response()->json([
            'message' => 'Zmieniono nazwę działu'
        ]);
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json([
            'message' => 'Dział usunięty'
        ]);
    }


    public function getDepartmentsSubdepartmentsCategories()
    {
        $departments = Department::all();
        $data = [];

        foreach ($departments as $department) {
            $subdepartments = Subdepartment::where('id_department', $department->id)->get();
            $subdepartmentData = [];

            foreach ($subdepartments as $subdepartment) {
                $categories = Category::where('id_subdepartment', $subdepartment->id)->get();
                $subdepartmentData[] = [
                    'name' => $subdepartment->name,
                    'id_subdepartment' => $subdepartment->id,
                    'categories' => $categories
                ];
            }

            $data[] = [
                'name' => $department->name,
                'id_department' => $department->id,
                'subdepartments' => $subdepartmentData
            ];
        }

        return response()->json([
            'departments' => $data
        ]);
    }

    public function show_department($id)
    {
        $department = Department::where('id', $id)->first();
        $subdepartments = Subdepartment::where('id_department', $id)->get();
        $data = [
            'name' => $department->name,
            'id_department' => $department->id,
            'subdepartments' => $subdepartments
        ];

        return response()->json([
            'department' => $data
        ]);
    }
    public function show_only_department($id)
    {
        $department = Department::where('id', $id)->first();
        $data = [
            'name' => $department->name,
            'id_department' => $department->id,
        ];

        return response()->json([
            'department' => $data
        ]);
    }
}
