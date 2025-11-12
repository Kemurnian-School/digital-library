@extends('layouts.client')

@section('content')
    <section class="flex w-full justify-center px-4 py-8">
        <div class="flex flex-1 gap-2 flex w-full justify-center items-center max-w-6xl">
            @foreach ($books as $book)
                <x-client.book-card :title="$book->name" :link="route('books.preview', [
                    'year' => $book->year,
                    'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                    'id' => $book->id,
                ])" :author="$book->author" :year="(string) $book->year"
                    :genre="$book->genre->name" :cover-src="asset('storage/' . $book->cover_path)" />
            @endforeach
        </div>
    </section>
@endsection
