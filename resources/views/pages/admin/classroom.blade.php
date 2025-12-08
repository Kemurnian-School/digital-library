@extends('layouts.admin')

@section('content')
<main class="p-4">
    {{-- Create Form --}}
    <div class="flex items-center gap-2 mb-4">
        <span>New classroom:</span>

        <form action="{{ route('admin.classrooms.store') }}" method="POST" class="flex gap-2 items-center">
            @csrf
            <input type="text" name="classroom_id" placeholder="Enter new classroom" required class="border px-2 py-1 rounded">

            <button type="submit" class="bg-[#872109] text-white py-2 px-4 rounded-sm cursor-pointer">
                Add
            </button>
        </form>
    </div>

    {{-- Delete Form --}}
    <form action="{{ route('admin.classrooms.bulkDelete') }}" method="POST" id="delete-form">
        @csrf
        @method('DELETE')

        {{-- Classroom List Table --}}
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-lg font-semibold mb-2 text-black">All Classrooms</h2>

            <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer"
                onclick="return confirm('Are you sure you want to delete the selected classrooms?')">
                Delete Selected
            </button>
        </div>

        <table class="border border-gray-300 rounded-sm w-full">
            <thead class="bg-red-600 text-white">
                <tr>
                    <th class="py-2 px-4 text-left">ID</th>
                    <th class="py-2 px-4 text-left">Classroom</th>
                    <th class="py-2 px-4 text-left">
                        <input type="checkbox" id="select-all" class="cursor-pointer">
                    </th>
                </tr>
            </thead>
            <tbody class="text-black">
                @forelse ($classrooms as $classroom)
                <tr class="border-t">
                    <td class="py-2 px-4">{{ $classroom->id }}</td>
                    <td class="py-2 px-4">{{ $classroom->classroom_id }}</td>
                    <td class="py-2 px-4">
                        <input type="checkbox" name="classroom_ids[]" value="{{ $classroom->id }}"
                            class="classroom-checkbox cursor-pointer">
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500">No classrooms available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </form>
</main>

<script>
    document.getElementById('select-all').addEventListener('change', function () {
        const checkboxes = document.querySelectorAll('.classroom-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection
