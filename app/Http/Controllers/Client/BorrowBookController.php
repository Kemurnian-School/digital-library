<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class BorrowBookController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'book_id' => 'required|integer|exists:books,id',
            'status' => 'required|string',
            'date_borrowed' => 'required|date',
            'date_returned' => 'nullable|date'
        ]);

        try {
            BorrowRecord::create($validated);
            return redirect()->back()->with('success', 'Borrow request submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to submit borrow request.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BorrowRecord $borrowRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BorrowRecord $borrowRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BorrowRecord $borrowRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BorrowRecord $borrowRecord)
    {
        //
    }
}
