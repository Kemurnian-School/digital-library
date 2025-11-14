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
