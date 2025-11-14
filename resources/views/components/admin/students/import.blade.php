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
