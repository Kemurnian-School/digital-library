@props(['students', 'search'])

<div class="mb-8">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold text-black">All Students</h2>
        <div class="flex gap-2">
            <button type="button" id="reset-btn"
                class="bg-yellow-600 text-white py-2 px-4 rounded-sm cursor-pointer hover:bg-yellow-700">
                Reset Password
            </button>
            <button type="button" id="delete-btn"
                class="bg-red-600 text-white py-2 px-4 rounded-sm cursor-pointer hover:bg-red-700">
                Delete Selected
            </button>
        </div>
    </div>

    {{-- Search Form --}}
    <form method="GET" action="{{ route('admin.students.index') }}" class="mb-4">
        <div class="flex gap-2">
            <input type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Search by NIS, Name, or Level..."
                class="flex-1 border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                class="bg-blue-600 text-white py-2 px-6 rounded-sm cursor-pointer hover:bg-blue-700">
                Search
            </button>
            @if($search)
                <a href="{{ route('admin.students.index') }}"
                    class="bg-gray-600 text-white py-2 px-6 rounded-sm cursor-pointer hover:bg-gray-700 flex items-center">
                    Clear
                </a>
            @endif
        </div>
    </form>

    <table class="border border-gray-300 rounded-sm w-full">
        <thead class="bg-red-600 text-white">
            <tr>
                <th class="py-2 px-4 text-left">NIS</th>
                <th class="py-2 px-4 text-left">Name</th>
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
                    <td class="py-2 px-4">{{ $student->name }}</td>
                    <td class="py-2 px-4">{{ strtoupper($student->level) }}</td>
                    <td class="py-2 px-4">
                        <input type="checkbox" name="studentsId[]" value="{{ $student->id }}"
                            class="student-checkbox cursor-pointer">
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">
                        @if($search)
                            No students found matching "{{ $search }}".
                        @else
                            No students available.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Hidden Reset Form --}}
<form id="reset-form" action="{{ route('admin.students.reset') }}" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <div id="reset-inputs"></div>
</form>

{{-- Hidden Delete Form --}}
<form id="delete-form" action="{{ route('admin.students.delete') }}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
    <div id="delete-inputs"></div>
</form>

<script>
    // Select all checkboxes
    document.getElementById('select-all').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Get selected student IDs
    function getSelectedIds() {
        const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
        return Array.from(checkedBoxes).map(cb => cb.value);
    }

    // Reset Password Button
    document.getElementById('reset-btn').addEventListener('click', function() {
        const selectedIds = getSelectedIds();

        if (selectedIds.length === 0) {
            alert('Please select at least one student to reset password.');
            return;
        }

        if (!confirm('Are you sure you want to reset the password for the selected students?')) {
            return;
        }

        // Add selected IDs to reset form
        const resetInputs = document.getElementById('reset-inputs');
        resetInputs.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'studentsId[]';
            input.value = id;
            resetInputs.appendChild(input);
        });

        // Submit reset form
        document.getElementById('reset-form').submit();
    });

    // Delete Button
    document.getElementById('delete-btn').addEventListener('click', function() {
        const selectedIds = getSelectedIds();

        if (selectedIds.length === 0) {
            alert('Please select at least one student to delete.');
            return;
        }

        if (!confirm('Are you sure you want to delete the selected students?')) {
            return;
        }

        // Add selected IDs to delete form
        const deleteInputs = document.getElementById('delete-inputs');
        deleteInputs.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'studentsId[]';
            input.value = id;
            deleteInputs.appendChild(input);
        });

        // Submit delete form
        document.getElementById('delete-form').submit();
    });
</script>
