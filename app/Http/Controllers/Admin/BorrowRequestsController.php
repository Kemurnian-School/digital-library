<?php

namespace App\Http\Controllers;

use App\Models\ActiveBorrowRecord;
use Illuminate\Http\Request;

class BorrowRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowRequests = ActiveBorrowRecord::select('id', 'student_id', 'book_id', 'status');
        return view('pages.admin.borrow-request', compact('borrowRequests'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ActiveBorrowRecord $activeBorrowRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ActiveBorrowRecord $activeBorrowRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ActiveBorrowRecord $activeBorrowRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActiveBorrowRecord $activeBorrowRecord)
    {
        //
    }
}
