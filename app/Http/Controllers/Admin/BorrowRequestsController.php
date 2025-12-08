<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequests;
use Illuminate\Http\Request;

class BorrowRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowRequests = BorrowRequests::select('id', 'student_id', 'book_id', 'status', 'classroom_id', 'date_borrowed', 'date_returned')->get();
        $classrooms = \App\Models\Classroom::all();

        return view('pages.admin.borrow-request', compact('borrowRequests', 'classrooms'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BorrowRequests $activeBorrowRecord)
    {
        //
    }
}
