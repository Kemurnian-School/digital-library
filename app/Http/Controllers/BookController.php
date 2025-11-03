<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display form + list of all books.
     */
    public function index()
    {
        $genres = Genres::select('id', 'name')->get();
        $books = Book::with('genre:id,name')->select('id', 'name', 'author', 'genre_id', 'year')->get();
        return view('pages.books', compact('genres', 'books'));
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
        ]);

        $genre = Genres::find($validated['genre_id']);
        $genreName = str_replace(' ', '_', strtolower($genre->name));

        // Create the book first to get the ID
        $book = Book::create([
            'name' => $validated['name'],
            'year' => $validated['year'],
            'author' => $validated['author'],
            'genre_id' => $validated['genre_id'],
            'file_path' => '',
        ]);

        // Store with book ID as filename
        $folder = "books/{$validated['year']}/{$genreName}";
        $filename = $book->id . '.pdf';
        $path = $request->file('file_path')->storeAs($folder, $filename, 'public');

        // Update the file_path
        $book->update(['file_path' => $path]);

        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

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

        return view('pages.book-preview', compact('book'));
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
            // Delete the PDF file first
            if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
                Storage::disk('public')->delete($book->file_path);
            }

            // Delete the database entry
            $book->delete();
        }

        return redirect()->route('books.index')->with('success', count($books) . ' book(s) deleted successfully.');
    }
}
