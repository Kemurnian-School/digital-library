@extends('layouts.admin')
@section('content')
<main class="p-4">
    <h2 class="text-lg font-semibold mb-4 text-black">Borrow Requests</h2>

    <table class="border border-gray-300 rounded-sm w-full">
        <thead class="bg-red-600 text-white">
            <tr>
                <th class="py-2 px-4 text-left">ID</th>
                <th class="py-2 px-4 text-left">Student ID</th>
                <th class="py-2 px-4 text-left">Book ID</th>
                <th class="py-2 px-4 text-left">Status</th>
                <th class="py-2 px-4 text-left">Classroom</th>
                <th class="py-2 px-4 text-left">Date Borrowed</th>
                <th class="py-2 px-4 text-left">Date Returned</th>
                <th class="py-2 px-4 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-black">
            @forelse ($borrowRequests as $borrowRequest)
            <tr class="border-t">
                <td class="py-2 px-4">{{ $borrowRequest->id }}</td>
                <td class="py-2 px-4">{{ $borrowRequest->student_id }}</td>
                <td class="py-2 px-4">{{ $borrowRequest->book_id }}</td>
                <td class="py-2 px-4">
                    <span class="px-2 py-1 rounded text-sm
                        @if($borrowRequest->status === 'pending') bg-yellow-200 text-yellow-800
                        @elseif($borrowRequest->status === 'approved') bg-green-200 text-green-800
                        @elseif($borrowRequest->status === 'rejected') bg-red-200 text-red-800
                        @else bg-gray-200 text-gray-800
                        @endif">
                        {{ ucfirst($borrowRequest->status->value) }}
                    </span>
                </td>
                <td class="py-2 px-4">
                    <select name="classroom_id" class="border px-2 py-1 rounded w-full"
                        @if($borrowRequest->status !== 'pending') disabled @endif>
                        <option value="">Select Classroom</option>
                        @foreach($classrooms ?? [] as $classroom)
                            <option value="{{ $classroom->id }}"
                                {{ $borrowRequest->classroom_id == $classroom->id ? 'selected' : '' }}>
                                {{ $classroom->classroom_id }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td class="py-2 px-4">
                    <input type="date" name="date_borrowed"
                        value="{{ $borrowRequest->date_borrowed }}"
                        class="border px-2 py-1 rounded w-full"
                        @if($borrowRequest->status !== 'pending') disabled @endif>
                </td>
                <td class="py-2 px-4">
                    <input type="date" name="date_returned"
                        value="{{ $borrowRequest->date_returned }}"
                        class="border px-2 py-1 rounded w-full"
                        @if($borrowRequest->status !== 'pending') disabled @endif>
                </td>
                <td class="py-2 px-4">
                    <div class="flex gap-2">
                        @if($borrowRequest->status === 'pending')
                            <button type="button"
                                class="bg-green-600 text-white py-1 px-3 rounded-sm cursor-pointer hover:bg-green-700">
                                Approve
                            </button>
                            <button type="button"
                                class="bg-red-600 text-white py-1 px-3 rounded-sm cursor-pointer hover:bg-red-700">
                                Reject
                            </button>
                        @elseif($borrowRequest->status === 'approved')
                            <button type="button"
                                class="bg-blue-600 text-white py-1 px-3 rounded-sm cursor-pointer hover:bg-blue-700">
                                Finish
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center py-4 text-gray-500">No borrow requests available.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</main>
@endsection
