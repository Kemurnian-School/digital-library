<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Show PDF preview page
     */
    public function preview($year, $genre, $id)
    {
        $book = Book::with('genre')->findOrFail($id);

        // Verify the URL parameters match the book
        $genreName = str_replace(' ', '_', strtolower($book->genre->name));

        if ($book->year != $year || $genreName != $genre) {
            abort(404);
        }

        return view('pages.client.book-preview', compact('book'));
    }

    /**
     * API: Serve the PDF file
     */
    public function servePdf($year, $genre, $id)
    {
        $book = Book::with('genre')->findOrFail($id);

        // Verify the URL parameters match
        $genreName = str_replace(' ', '_', strtolower($book->genre->name));

        if ($book->year != $year || $genreName != $genre) {
            abort(404);
        }

        $path = $book->file_path;

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'PDF file not found');
        }

        $fullPath = Storage::disk('public')->path($path);

        return response()->file($fullPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $book->name . '.pdf"'
        ]);
    }
}
