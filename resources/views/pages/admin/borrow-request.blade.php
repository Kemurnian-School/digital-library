@extends('layouts.admin')

@section('content')
<main class="p-4">
    <h2 class="text-lg font-semibold mb-4 text-black">Borrow Requests</h2>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto">
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
                            @if($borrowRequest->status->value === 'pending') bg-yellow-200 text-yellow-800
                            @elseif($borrowRequest->status->value === 'borrowed') bg-green-200 text-green-800
                            @elseif($borrowRequest->status->value === 'rejected') bg-red-200 text-red-800
                            @elseif($borrowRequest->status->value === 'finished') bg-blue-200 text-blue-800
                            @else bg-gray-200 text-gray-800
                            @endif">
                            {{ ucfirst($borrowRequest->status->value) }}
                        </span>
                    </td>
                    <td class="py-2 px-4">
                        <form id="form-{{ $borrowRequest->id }}" action="{{ route('admin.borrow-requests.update', $borrowRequest->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <select name="classroom_id" class="border px-2 py-1 rounded w-full bg-white"
                                @if($borrowRequest->status->value !== 'pending') disabled @endif>
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
                                class="border px-2 py-1 rounded w-full bg-white"
                                @if($borrowRequest->status->value !== 'pending') disabled @endif>
                    </td>
                    <td class="py-2 px-4">
                            <input type="date" name="date_returned"
                                value="{{ $borrowRequest->date_returned }}"
                                class="border px-2 py-1 rounded w-full bg-white"
                                @if($borrowRequest->status->value === 'pending') disabled
                                @elseif($borrowRequest->status->value !== 'borrowed') disabled @endif>
                    </td>
                    <td class="py-2 px-4">
                            <div class="flex gap-2">
                                @if($borrowRequest->status->value === 'pending')
                                    <button type="submit" name="action" value="approve"
                                        class="bg-green-600 text-white py-1 px-3 rounded-sm hover:bg-green-700"
                                        onclick="return validateApproval(this.form)">
                                        Approve
                                    </button>
                                    <button type="submit" name="action" value="reject"
                                        class="bg-red-600 text-white py-1 px-3 rounded-sm hover:bg-red-700">
                                        Reject
                                    </button>
                                @elseif($borrowRequest->status->value === 'borrowed')
                                    <button type="submit" name="action" value="finish"
                                        class="bg-blue-600 text-white py-1 px-3 rounded-sm hover:bg-blue-700">
                                        Finish
                                    </button>
                                @endif
                            </div>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-4 text-gray-500">No borrow requests available.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
function validateApproval(form) {
    const classroom = form.querySelector('[name="classroom_id"]').value;
    const dateBorrowed = form.querySelector('[name="date_borrowed"]').value;

    if (!classroom) {
        alert('Please select a classroom before approving.');
        return false;
    }

    if (!dateBorrowed) {
        alert('Please select a date borrowed before approving.');
        return false;
    }

    return true;
}
</script>
@endsection
