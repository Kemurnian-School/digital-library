@extends('layouts.admin')

@section('content')
    <main class="p-4">
        {{-- Book Info --}}
        <div class="mb-4">
            <a href="{{ route('admin.books.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">
                ← Back to Books
            </a>
            <h1 class="text-2xl font-bold text-black">{{ $book->name }}</h1>
            <p class="text-gray-600">by {{ $book->author }} ({{ $book->year }})</p>
            <p class="text-gray-600">Genre: {{ $book->genre->name }}</p>
        </div>

        {{-- PDF Viewer --}}
        <div class="w-full" style="height: calc(100vh - 200px);">
            <iframe
                src="{{ route('admin.books.serve', [
                    'year' => $book->year,
                    'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                    'id' => $book->id,
                ]) }}"
                class="w-full h-full border border-gray-300 rounded" type="application/pdf">
                <p>Your browser does not support PDFs.
                    <a href="{{ route('admin.books.serve', [
                        'year' => $book->year,
                        'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                        'id' => $book->id,
                    ]) }}"
                        class="text-blue-600">Download the PDF</a>
                </p>
            </iframe>
        </div>
    </main>
@endsection
