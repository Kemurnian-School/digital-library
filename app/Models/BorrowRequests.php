<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BorrowStatus;

class BorrowRequests extends Model
{
    use HasFactory;

    protected $table = 'borrow_requests';

    protected $fillable = [
        'student_id',
        'classroom_id',
        'book_id',
        'status',
        'date_borrowed',
        'date_returned'
    ];

    protected $casts = [
        'status' => BorrowStatus::class,
        'date_borrowed' => 'date',
        'date_returned' => 'date',
    ];

    /**
     * Get the student who borrowed the book
     */
    public function student()
    {
        return $this->belongsTo(Students::class);
    }

    /**
     * Get the classroom
     */
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    /**
     * Get the book that was borrowed
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if book is currently borrowed
     */
    public function isBorrowed()
    {
        return in_array($this->status, ['pending', 'active']);
    }

    /**
     * Check if book has been returned
     */
    public function isReturned()
    {
        return $this->status === 'returned';
    }
}
