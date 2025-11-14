@extends('layouts.admin')

@section('content')
<main class="p-4 max-w-7xl mx-auto">
    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-black">Student Management</h1>
    </div>

    {{-- Quick Actions --}}
    <div class="flex gap-4 mb-6">
        <a href="{{ route('admin.students.create') }}"
           class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">
            Add Student Manually
        </a>
        <a href="{{ route('admin.students.import') }}"
           class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
            Import from File
        </a>
    </div>

    {{-- Messages --}}
    @if(session('success'))
        <x-alert type="success" :message="session('success')" />
    @endif

    @if($errors->any())
        <x-alert type="error" :messages="$errors->all()" />
    @endif

    {{-- Search --}}
    <form method="GET" class="mb-6">
        <div class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search by NIS, Name, or Level..."
                class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded hover:bg-blue-700">
                Search
            </button>
            @if(request('search'))
                <a href="{{ route('admin.students.index') }}"
                   class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-700 flex items-center">
                    Clear
                </a>
            @endif
        </div>
    </form>

    {{-- Bulk Actions Form --}}
    <form method="POST" action="{{ route('admin.students.bulk-action') }}">
        @csrf

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-black">All Students</h2>
            <div class="flex gap-2">
                <button type="submit" name="action" value="reset"
                    onclick="return confirm('Are you sure you want to reset passwords for selected students?')"
                    class="bg-yellow-600 text-white py-2 px-4 rounded hover:bg-yellow-700">
                    Reset Password
                </button>
                <button type="submit" name="action" value="delete"
                    onclick="return confirm('Are you sure you want to delete selected students?')"
                    class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                    Delete Selected
                </button>
            </div>
        </div>

        <div class="overflow-x-auto border border-gray-300 rounded">
            <table class="w-full">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left w-12">
                            <input type="checkbox" id="select-all" class="cursor-pointer">
                        </th>
                        <th class="py-3 px-4 text-left">NIS</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Jenjang</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($students as $student)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <input type="checkbox" name="students[]"
                                    value="{{ $student->id }}"
                                    class="student-checkbox cursor-pointer">
                            </td>
                            <td class="py-3 px-4">{{ $student->nis }}</td>
                            <td class="py-3 px-4">{{ $student->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 bg-gray-200 rounded text-sm">
                                    {{ strtoupper($student->level) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.students.edit', $student) }}"
                                   class="text-blue-600 hover:underline mr-3">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                @if(request('search'))
                                    No students found matching "{{ request('search') }}".
                                @else
                                    No students available.
                                    <a href="{{ route('admin.students.create') }}" class="text-blue-600 hover:underline">
                                        Add your first student
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>

    {{-- Pagination --}}
    @if($students->hasPages())
        <div class="mt-6">
            {{ $students->links() }}
        </div>
    @endif
</main>

{{-- Minimal JavaScript for "Select All" --}}
<script>
document.getElementById('select-all')?.addEventListener('change', function() {
    document.querySelectorAll('.student-checkbox').forEach(cb => cb.checked = this.checked);
});
</script>
@endsection
