<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ActiveBorrowRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BorrowBookController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Borrow Request Data:', $request->all());
        Log::info('Session Data:', ['student_id' => session('student_id')]);

        $validated = $request->validate([
            'student_id' => 'required|integer|exists:students,id',
            'book_id' => 'required|integer|exists:books,id',
            'status' => 'required|string|in:pending,active',
            'date_borrowed' => 'required|date',
        ]);

        try {
            $existingBorrow = ActiveBorrowRecord::where('student_id', $validated['student_id'])
                ->where('book_id', $validated['book_id'])
                ->whereIn('status', ['pending', 'active'])
                ->first();

            if ($existingBorrow) {
                return redirect()->back()->with('error', 'You already have a pending or active borrow request for this book.');
            }

            ActiveBorrowRecord::create($validated);

            return redirect()->back()->with('success', 'Borrow request submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Borrow Request Failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Failed to submit borrow request: ' . $e->getMessage())
                ->withInput();
        }
    }
}
