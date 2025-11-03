<?php

namespace App\Http\Controllers;

use App\Imports\StudentsImport;
use App\Models\Students;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Students::select('id', 'nis', 'level')->get();
        return view('pages.students', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv|max:2048',
        ]);
        Excel::import(new StudentsImport, $request->file('file'));

        return back()->with('success', 'export successful');
    }

    /**
     * Display the specified resource.
     */
    public function show(Students $students)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Students $students)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Students $students)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Students $students)
    {
        //
    }

    /**
     * Bulkdelete students
     */
    public function bulkDelete(Request $request)
    {
        $studentsId = $request->input('studentsId');

        if (!$studentsId) {
            return response()->json(['error' => 'invalid input'], 400);
        }

        $deleted = Students::whereIn('id', $studentsId)->delete();

        return response()->json([
            'success' => true,
            'deleted_count' => $deleted,
        ]);
    }
}
