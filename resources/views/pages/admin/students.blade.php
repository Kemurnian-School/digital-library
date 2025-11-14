@extends('layouts.admin')

@section('content')
    <main class="p-4">
        {{-- Import Form --}}
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 text-black">Import Students from File</h2>
            <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="border border-gray-300 rounded-sm overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left text-black w-1/4">Field</th>
                                <th class="py-2 px-4 text-left text-black">Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="py-2 px-4 text-black">Import Students File</td>
                                <td class="py-2 px-4">
                                    <input type="file" name="file" accept=".xlsx,.csv" required
                                        class="border border-gray-300 rounded px-2 py-1">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-[#872109] text-white py-2 px-4 rounded-sm cursor-pointer hover:bg-[#6a1a07]">
                        Import
                    </button>
                </div>
            </form>
        </div>

        {{-- Create Form (Manual Input) --}}
        <div class="mb-8">
            <h2 class="text-lg font-semibold mb-4 text-black">Add Student Manually</h2>
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf
                <div class="border border-gray-300 rounded-sm overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-4 text-left text-black w-1/4">Field</th>
                                <th class="py-2 px-4 text-left text-black">Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="py-2 px-4 text-black">NIS</td>
                                <td class="py-2 px-4">
                                    <input type="text" name="nis" value="{{ old('nis') }}" required
                                        class="border border-gray-300 rounded px-3 py-2 w-full"
                                        placeholder="Enter student NIS">
                                    @error('nis')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                            <tr class="border-t">
                                <td class="py-2 px-4 text-black">Name</td>
                                <td class="py-2 px-4">
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="border border-gray-300 rounded px-3 py-2 w-full"
                                        placeholder="Enter student name">
                                    @error('name')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded-sm cursor-pointer hover:bg-green-700">
                        Add Student
                    </button>
                </div>
            </form>
        </div>

        {{-- Delete Form --}}
        <form action="{{ route('admin.students.delete') }}" method="POST" id="delete-form">
            @csrf
            @method('DELETE')

            {{-- Student List Table --}}
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold mb-2 text-black">All Students</h2>
                <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer hover:bg-red-700"
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

        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
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
