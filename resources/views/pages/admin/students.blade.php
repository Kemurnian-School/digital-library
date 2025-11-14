@extends('layouts.admin')

@section('content')
    <main class="p-4">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-admin.students.import />

        <x-admin.students.create />

        <x-admin.students.table :students="$students" :search="$search ?? ''" />
    </main>
@endsection
