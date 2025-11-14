@extends('layouts.admin')

@section('content')
<main class="p-4 max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-blue-600 hover:underline">
            ← Back to Students
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-black">Add Student Manually</h1>
    </div>

    @if($errors->any())
        <x-alert type="error" :messages="$errors->all()" />
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST" class="bg-white border border-gray-300 rounded p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="nis" class="block text-sm font-medium text-black mb-2">
                    NIS <span class="text-red-600">*</span>
                </label>
                <input type="text"
                    name="nis"
                    id="nis"
                    value="{{ old('nis') }}"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter student NIS">
                @error('nis')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-black mb-2">
                    Name <span class="text-red-600">*</span>
                </label>
                <input type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter student name">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-black mb-2">
                    Jenjang (Level) <span class="text-red-600">*</span>
                </label>
                <select name="level"
                    id="level"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Level</option>
                    <option value="sd" {{ old('level') == 'sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ old('level') == 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ old('level') == 'sma' ? 'selected' : '' }}>SMA</option>
                </select>
                @error('level')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-green-600 text-white py-2 px-6 rounded hover:bg-green-700">
                Add Student
            </button>
            <a href="{{ route('admin.students.index') }}"
                class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-700 inline-block">
                Cancel
            </a>
        </div>
    </form>
</main>
@endsectionextends('layouts.admin')

@section('content')
<main class="p-4 max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.students.index') }}" class="text-blue-600 hover:underline">
            ← Back to Students
        </a>
    </div>

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-black">Add Student Manually</h1>
    </div>

    @if($errors->any())
        <x-alert type="error" :messages="$errors->all()" />
    @endif

    <form action="{{ route('admin.students.store') }}" method="POST" class="bg-white border border-gray-300 rounded p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="nis" class="block text-sm font-medium text-black mb-2">
                    NIS <span class="text-red-600">*</span>
                </label>
                <input type="text"
                    name="nis"
                    id="nis"
                    value="{{ old('nis') }}"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter student NIS">
                @error('nis')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-black mb-2">
                    Name <span class="text-red-600">*</span>
                </label>
                <input type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Enter student name">
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="level" class="block text-sm font-medium text-black mb-2">
                    Jenjang (Level) <span class="text-red-600">*</span>
                </label>
                <select name="level"
                    id="level"
                    required
                    class="border border-gray-300 rounded px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Select Level</option>
                    <option value="sd" {{ old('level') == 'sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ old('level') == 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ old('level') == 'sma' ? 'selected' : '' }}>SMA</option>
                </select>
                @error('level')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit"
                class="bg-green-600 text-white py-2 px-6 rounded hover:bg-green-700">
                Add Student
            </button>
            <a href="{{ route('admin.students.index') }}"
                class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-700 inline-block">
                Cancel
            </a>
        </div>
    </form>
</main>
@endsection
