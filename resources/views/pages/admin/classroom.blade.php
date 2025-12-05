@extends('layouts.admin')

@section('content')
<main>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Classroom</th>
                <th>Select</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classrooms as $classroom)
            <tr>
                <td>{{ $classroom->id }}</td>
                <td>{{ $classroom->classroom_id }}</td>
            </tr>
            @endforeach

        </tbody>

    </table>
</main>
@endsection
