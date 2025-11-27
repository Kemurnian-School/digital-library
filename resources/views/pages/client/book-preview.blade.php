@extends('layouts.client')

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js"></script>
    @vite('resources/js/pdfviewer.js')
@endpush

@section('content')
    <main class="p-4 flex justify-between h-[96vh]">
        {{-- Book Info --}}
        <section>
            <a href="{{ url('/') }}" class="flex items-center bg-[#e64553] hover:bg-[#d20f39] rounded-md cursor-pointer text-white w-20 gap-2 p-2 transition-colors">
                <div class="w-5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M5.82843 6.99955L8.36396 9.53509L6.94975 10.9493L2 5.99955L6.94975 1.0498L8.36396 2.46402L5.82843 4.99955H13C17.4183 4.99955 21 8.58127 21 12.9996C21 17.4178 17.4183 20.9996 13 20.9996H4V18.9996H13C16.3137 18.9996 19 16.3133 19 12.9996C19 9.68584 16.3137 6.99955 13 6.99955H5.82843Z">
                        </path>
                    </svg>
                </div>
                Back
            </a>
            <div class="flex flex-col">
                <div class="flex items-center gap-2">
                    <h1 class="text-2xl font-bold text-black">{{ $book->name }}</h1>
                    <p class="text-gray-600">by {{ $book->author }} ({{ $book->year }})</p>
                </div>
                <p class="text-gray-600">Genre: {{ $book->genre->name }}</p>
            </div>

            {{-- Borrow Button --}}
            @if(session()->has('student_id'))
                <form action="{{ url('borrow/create') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ session('student_id') }}">
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <input type="hidden" name="date_borrowed" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="status" value="pending">

                    <button type="submit" class="mt-4 flex items-center bg-green-600 hover:bg-green-700 rounded-md text-white gap-2 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M21 16.42V4.993C21 4.445 20.555 4 20.007 4H3.993C3.445 4 3 4.445 3 4.993v14.014c0 .548.445.993.993.993h16.014a.994.994 0 0 0 .993-.993zM19 11V6h2v5h-2zm0 2h2v5h-2v-5zM5 6h12v12H5V6zm2 2v8h8V8H7zm2 2h4v4H9v-4z"/>
                        </svg>
                        Borrow This Book
                    </button>
                </form>
            @endif

            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        <div id="book-viewer-container" class="mt-1 flex flex-col items-center justify-center relative select-none"
            data-pdf-url="{{ route('books.serve', [
                'year' => $book->year,
                'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                'id' => $book->id,
            ]) }}">

            {{-- Loading Spinner --}}
            <div id="loading-spinner" class="absolute z-20 flex flex-col items-center text-gray-700">
                <svg class="animate-spin h-10 w-10 text-[#e64553]" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="mt-2 font-semibold">Loading Book...</span>
            </div>

            {{-- Book-style Display --}}
            <div id="book" class="hidden items-center justify-center w-full h-full relative" style="perspective: 1000px;">
                <div id="page-container" class="flex w-full h-full justify-center items-center p-4">
                    <canvas id="pdf-canvas-left" class="border border-gray-300 rounded-md shadow-lg"></canvas>
                    <canvas id="pdf-canvas-right" class="border border-gray-300 rounded-md shadow-lg"></canvas>
                </div>
                <div id="prev-page-clickable" class="absolute left-0 top-0 w-1/2 h-full cursor-pointer z-10"></div>
                <div id="next-page-clickable" class="absolute right-0 top-0 w-1/2 h-full cursor-pointer z-10"></div>
            </div>

            {{-- Page Navigation Controls --}}
            <div id="navigation-controls" class="w-full flex justify-center items-center p-2 gap-4">
                <button id="prev-page" class="bg-gray-700 hover:bg-gray-900 text-white font-bold py-1 px-2 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Previous
                </button>
                <div class="text-lg font-semibold text-gray-800">
                    Page <span id="page-num-left">0</span> & <span id="page-num-right">0</span> of <span id="page-count">0</span>
                </div>
                <button id="next-page" class="bg-gray-700 hover:bg-gray-900 text-white font-bold py-1 px-2 rounded-md transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Next
                </button>
            </div>

        </div>
    </main>
@endsection
