<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'book_id',
        'status',
        'date_borrowed',
        'date_returned'
    ];

    protected $casts = [
        'status' => 'boolean',
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
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    /**
     * Get the book that was borrowed
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if book is currently borrowed (status = true means borrowed)
     */
    public function isBorrowed()
    {
        return $this->status === true;
    }

    /**
     * Check if book has been returned (status = false means returned)
     */
    public function isReturned()
    {
        return $this->status === false;
    }
}
