@extends('layouts.admin')

@section('content')
    <main class="p-4">
        {{-- Import Form --}}
        <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="mb-8">
            @csrf
            <x-admin.table :columns="['Field', 'Input']" :rows="[['label' => 'Import Students File', 'name' => 'file', 'type' => 'file']]" />
            <div class="mt-4">
                <button type="submit" class="bg-[#872109] text-white py-2 px-4 rounded-sm cursor-pointer">
                    Import
                </button>
            </div>
        </form>

        {{-- Delete Form --}}
        <form action="{{ route('students.delete') }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')

            {{-- Student List Table --}}
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold mb-2 text-black">All Students</h2>

                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer"
                    onclick="return confirm('Are you sure you want to delete the selected students?')">
                    Delete Selected
                </button>
            </div>

            <table class="border border-gray-300 rounded-sm w-full">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">NIS</th>
                        <th class="py-2 px-4 text-left">Jenjang</th>
                        <th class="py-2 px-4 text-left">
                            <input type="checkbox" id="select-all" class="cursor-pointer">
                        </th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($students as $student)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $student->nis }}</td>
                            <td class="py-2 px-4">{{ $student->level }}</td>
                            <td class="py-2 px-4">
                                <input type="checkbox" name="studentsId[]" value="{{ $student->id }}"
                                    class="student-checkbox cursor-pointer">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">
                                No students available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>
    </main>

    <script>
        // Select all checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.student-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Prevent delete if no checkbox is selected
        document.getElementById('delete-form').addEventListener('submit', function(e) {
            const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
            if (checkedBoxes.length === 0) {
                e.preventDefault();
                alert('Please select at least one student to delete.');
            }
        });
    </script>
@endsection
