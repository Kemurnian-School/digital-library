<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BorrowRequests;
use App\Enums\BorrowStatus;
use Illuminate\Http\Request;

class BorrowRequestsController extends Controller
{
    public function index()
    {
        $borrowRequests = BorrowRequests::select('id', 'student_id', 'book_id', 'status', 'classroom_id', 'date_borrowed', 'date_returned')->get();
        $classrooms = \App\Models\Classroom::all();
        return view('pages.admin.borrow-request', compact('borrowRequests', 'classrooms'));
    }

    public function update(Request $request, $id)
    {
        $borrowRequest = BorrowRequests::findOrFail($id);
        $action = $request->input('action');

        if ($action === 'approve') {
            $validated = $request->validate([
                'classroom_id' => 'required|exists:classroom,id',
                'date_borrowed' => 'required|date',
            ], [
                'classroom_id.required' => 'Please select a classroom before approving.',
                'classroom_id.exists' => 'The selected classroom is invalid.',
                'date_borrowed.required' => 'Please select a date borrowed before approving.',
                'date_borrowed.date' => 'The date borrowed must be a valid date.',
            ]);

            $borrowRequest->update([
                'status' => BorrowStatus::BORROWED,
                'classroom_id' => $validated['classroom_id'],
                'date_borrowed' => $validated['date_borrowed'],
            ]);

            return redirect()->back()->with('success', 'Borrow request approved successfully!');
        }

        if ($action === 'reject') {
            $borrowRequest->update(['status' => BorrowStatus::REJECTED]);

            return redirect()->back()->with('success', 'Borrow request rejected.');
        }

        if ($action === 'finish') {
            $validated = $request->validate([
                'date_returned' => 'required|date|after_or_equal:' . $borrowRequest->date_borrowed,
            ], [
                'date_returned.required' => 'Please select a date returned before finishing.',
                'date_returned.date' => 'The date returned must be a valid date.',
                'date_returned.after_or_equal' => 'The date returned must be on or after the date borrowed.',
            ]);

            $borrowRequest->update([
                'status' => BorrowStatus::FINISHED,
                'date_returned' => $validated['date_returned'],
            ]);

            return redirect()->back()->with('success', 'Borrow request finished.');
        }

        return redirect()->back();
    }
}
