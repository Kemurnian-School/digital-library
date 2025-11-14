@extends('layouts.admin')

@section('content')
<main class="p-4 max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-blue-600 hover:underline">
            ← Back to Students
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-black">Import Students from File</h1>
        <p class="text-gray-600 mt-2">Upload an Excel (.xlsx) or CSV file containing student data.</p>
    </div>

    @if($errors->any())
        <x-alert type="error" :messages="$errors->all()" />
    @endif

    <form action="{{ route('admin.students.import') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white border border-gray-300 rounded p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="file" class="block text-sm font-medium text-black mb-2">
                    Import Students File <span class="text-red-600">*</span>
                </label>
                <input type="file"
                    name="file"
                    id="file"
                    accept=".xlsx,.csv"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full">
                <p class="text-sm text-gray-500 mt-1">Accepted formats: .xlsx, .csv</p>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded p-4">
                <h3 class="font-semibold text-black mb-2">File Format Requirements:</h3>
                <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                    <li>Column 1: NIS (Student ID Number)</li>
                    <li>Column 2: Name (Student Full Name)</li>
                    <li>Column 3: Level (sd/smp/sma)</li>
                    <li>First row should contain headers</li>
                </ul>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-[#872109] text-white py-2 px-6 rounded hover:bg-[#6a1a07]">
                Import Students
            </button>
            <a href="{{ route('admin.students.index') }}"
                class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-700 inline-block">
                Cancel
            </a>
        </div>
    </form>
</main>
@endsection
