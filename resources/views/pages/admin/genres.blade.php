@extends('layouts.admin')

@section('content')
    <main>
        <div class="flex items-center gap-2 mb-4">
            <span>New genre:</span>

            <form action="{{ route('genres.store') }}" method="POST" class="flex gap-2 items-center">
                @csrf
                <input type="text" name="name" placeholder="Enter new genre" required class="border px-2 py-1 rounded">

                <button type="submit" class="bg-[#872109] text-white py-2 px-4 rounded-sm cursor-pointer">
                    Add
                </button>
            </form>
        </div>

        <form action="{{ route('genres.delete') }}" method="POST" onsubmit="return confirmDelete()">
            @csrf
            @method('DELETE')

            <table class="w-xl border border-gray-300 rounded-sm overflow-hidden">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">ID</th>
                        <th class="py-2 px-4 text-left">Name</th>
                        <th class="py-2 px-4 text-left">Select</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($genres as $genre)
                        <tr class="border-t">
                            <td class="py-2 px-4 text-black">{{ $genre->id }}</td>
                            <td class="py-2 px-4 text-black">{{ $genre->name }}</td>
                            <td class="py-2 px-4">
                                <input type="checkbox" name="selected_genres[]" value="{{ $genre->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer">
                    Delete Selected
                </button>
            </div>
        </form>

        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to delete the selected genres?');
            }
        </script>
    </main>
@endsection
