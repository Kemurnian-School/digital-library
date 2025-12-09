<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BorrowRequests;

class Students extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nis',
        'level',
        'password'
    ];
    public function borrowRecords()
    {
        return $this->hasMany(BorrowRequests::class, 'student_id');
    }
}
