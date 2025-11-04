@extends('layouts.admin')

@section('content')
    <main class="p-4">
        {{-- Book Creation Form --}}
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="mb-8">
            @csrf
            <x-admin.table :columns="['Field', 'Input']" :rows="[
                ['label' => 'Name', 'name' => 'name', 'type' => 'text'],
                ['label' => 'Published Year', 'name' => 'year', 'type' => 'number'],
                ['label' => 'Author', 'name' => 'author', 'type' => 'text'],
                ['label' => 'Genre', 'name' => 'genre_id', 'type' => 'select', 'options' => $genres],
                ['label' => 'File', 'name' => 'file_path', 'type' => 'file'],
            ]" />
            <div class="mt-4">
                <button type="submit" class="bg-[#872109] text-white py-2 px-4 rounded-sm cursor-pointer">
                    Add Book
                </button>
            </div>
        </form>

        {{-- Delete Form --}}
        <form action="{{ route('books.bulkDelete') }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')

            {{-- Book List Table --}}
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold mb-2 text-black">All Books</h2>

                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer"
                    onclick="return confirm('Are you sure you want to delete the selected books?')">
                    Delete Selected
                </button>
            </div>

            <table class="border border-gray-300 rounded-sm w-full">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Author</th>
                        <th class="py-2 px-4 text-left">Year</th>
                        <th class="py-2 px-4 text-left">Genre</th>
                        <th class="py-2 px-4 text-left">Action</th>
                        <th class="py-2 px-4 text-left">Edit</th>
                        <th class="py-2 px-4 text-left">
                            <input type="checkbox" id="select-all" class="cursor-pointer">
                        </th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($books as $book)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $book->id }}</td>
                            <td class="py-2 px-4">{{ $book->name }}</td>
                            <td class="py-2 px-4">{{ $book->author }}</td>
                            <td class="py-2 px-4">{{ $book->year }}</td>
                            <td class="py-2 px-4">{{ $book->genre->name ?? 'N/A' }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('books.preview', [
                                    'year' => $book->year,
                                    'genre' => str_replace(' ', '_', strtolower($book->genre->name)),
                                    'id' => $book->id,
                                ]) }}"
                                    class="text-blue-600 hover:underline">
                                    Preview PDF
                                </a>
                            </td>
                            <td class="py-2 px-4">
                                <button type="button" class="text-gray-600 hover:text-gray-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </button>
                            </td>
                            <td class="py-2 px-4">
                                <input type="checkbox" name="book_ids[]" value="{{ $book->id }}"
                                    class="book-checkbox cursor-pointer">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">No books available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </main>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.book-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
@endsection
