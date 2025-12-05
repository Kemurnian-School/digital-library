<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Genres;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $sourcePdfPath = database_path('seeders/sources/file.pdf');
        $sourceCoverPath = database_path('seeders/sources/cover.png');

        if (!File::exists($sourcePdfPath) || !File::exists($sourceCoverPath)) {
            $this->command->error('Please create database/seeders/sources/sample.pdf and sample.png first!');
            return;
        }

        $genre = Genres::firstOrCreate([
            'name' => 'Computer Science'
        ]);

        $bookData = [
            'name'     => 'Book Name',
            'year'     => 2024,
            'author'   => 'Book Author',
            'genre_id' => $genre->id,
        ];

        $genreName = str_replace(' ', '_', strtolower($genre->name));
        $bookFolderName = Str::slug($bookData['name']);

        $baseFolder = "books/{$bookData['year']}/{$genreName}/{$bookFolderName}";

        $pdfFilename = 'file.pdf';
        $coverFilename = 'cover.png';

        Storage::disk('public')->put(
            "{$baseFolder}/{$pdfFilename}",
            file_get_contents($sourcePdfPath)
        );

        Storage::disk('public')->put(
            "{$baseFolder}/{$coverFilename}",
            file_get_contents($sourceCoverPath)
        );

        Book::create([
            'name'       => $bookData['name'],
            'year'       => $bookData['year'],
            'author'     => $bookData['author'],
            'genre_id'   => $bookData['genre_id'],
            'file_path'  => "{$baseFolder}/{$pdfFilename}",
            'cover_path' => "{$baseFolder}/{$coverFilename}",
        ]);

        $this->command->info('Book seeded with files successfully.');
    }
}
