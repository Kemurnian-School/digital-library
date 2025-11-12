@extends('layouts.client')

@section('content')
    <main class="p-4 flex">
        {{-- Book Info --}}
        <div class="mb-4 w-md">
            <a href="{{ url('/') }}" class="flex items-center bg-[#e64553] hover:bg-[#d20f39] rounded-md cursor-pointer text-white w-20 gap-2 py-1 px-2 mb-5">
                <div class="w-5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                        </path>
                    </svg>
                </div>
                Back
            </a>
            <h1 class="text-2xl font-bold text-black">{{ $book->name }}</h1>
            <p class="text-gray-600">by {{ $book->author }} ({{ $book->year }})</p>
            <p class="text-gray-600">Genre: {{ $book->genre->name }}</p>
        </div>

        {{-- PDF Viewer --}}
        <div class="w-full" style="height: calc(100vh - 100px);">
            <iframe
                src="{{ route('books.serve', [
                    'year' => $book->year,
                    'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                    'id' => $book->id,
                ]) }}"
                class="w-full h-full border border-gray-300 rounded" type="application/pdf">
                <p>Your browser does not support PDFs.
                    <a href="{{ route('books.serve', [
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
