@extends('layout.admin')

@section('content')
<div>
    @foreach($borrowRequests as $borrowRequest)
    <span>{{ $borrowReques->id }}</span>
    @endforeach
</div>

@endsection
