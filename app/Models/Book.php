<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'name',
        'year',
        'author',
        'genre_id',
        'file_path',
    ];

    public $timestamps = false;

    // Relationship: each book belongs to a genre
    public function genre()
    {
        return $this->belongsTo(Genres::class, 'genre_id');
    }
}
