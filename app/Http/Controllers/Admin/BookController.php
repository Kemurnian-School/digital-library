<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display form + list of all books.
     */
    public function index()
    {
        $genres = Genres::select('id', 'name')->get();
        $books = Book::with('genre:id,name')->select('id', 'name', 'author', 'genre_id', 'year', 'cover_path')->get();
        return view('pages.admin.books', compact('genres', 'books'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'author' => 'required|string|max:255',
            'genre_id' => 'required|exists:genres,id',
            'file_path' => 'required|file|mimes:pdf|max:10240',
            'cover_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $genre = Genres::find($validated['genre_id']);
        $genreName = str_replace(' ', '_', strtolower($genre->name));

        // Create a URL-friendly book name for the folder
        $bookFolderName = Str::slug($validated['name']);

        // Create the book first to get the ID
        $book = Book::create([
            'name' => $validated['name'],
            'year' => $validated['year'],
            'author' => $validated['author'],
            'genre_id' => $validated['genre_id'],
            'file_path' => '',
            'cover_path' => '',
        ]);

        // Base folder structure: books/year/genre/bookname/
        $baseFolder = "books/{$validated['year']}/{$genreName}/{$bookFolderName}";

        // Store PDF file
        $pdfFilename = 'file.pdf';
        $pdfPath = $request->file('file_path')->storeAs($baseFolder, $pdfFilename, 'public');

        // Store cover image
        $coverPath = '';
        if ($request->hasFile('cover_path')) {
            // User provided a cover image
            $coverExtension = $request->file('cover_path')->getClientOriginalExtension();
            $coverFilename = 'cover.' . $coverExtension;
            $coverPath = $request->file('cover_path')->storeAs($baseFolder, $coverFilename, 'public');
        } else {
            echo 'no cover';
        }

        // Update the file paths
        $book->update([
            'file_path' => $pdfPath,
            'cover_path' => $coverPath,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully.');
    }

    /**
     * Extract the first page of a PDF and save it as an image
     */

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

        return view('pages.admin.book-preview', compact('book'));
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

    /**
     * Delete multiple books at once.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'book_ids' => 'required|array',
            'book_ids.*' => 'exists:books,id',
        ]);

        $books = Book::whereIn('id', $request->book_ids)->get();

        foreach ($books as $book) {
            // Delete the PDF file
            if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
                Storage::disk('public')->delete($book->file_path);
            }

            // Delete the cover image
            if ($book->cover_path && Storage::disk('public')->exists($book->cover_path)) {
                Storage::disk('public')->delete($book->cover_path);
            }

            // Delete the entire book folder if empty
            $folderPath = dirname($book->file_path);
            if (Storage::disk('public')->exists($folderPath)) {
                $files = Storage::disk('public')->files($folderPath);
                if (empty($files)) {
                    Storage::disk('public')->deleteDirectory($folderPath);
                }
            }

            // Delete the database entry
            $book->delete();
        }

        return redirect()->route('admin.books.index')->with('success', count($books) . ' book(s) deleted successfully.');
    }
}
