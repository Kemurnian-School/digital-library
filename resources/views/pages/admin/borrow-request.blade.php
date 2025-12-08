@extends('layouts.admin')

@section('content')
<div>
    @foreach($borrowRequests as $borrowRequest)
    <span>{{ $borrowRequest->id }}</span>
    @endforeach
</div>

@endsection
