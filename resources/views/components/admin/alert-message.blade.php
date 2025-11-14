@props(['type' => 'success', 'message' => null, 'messages' => []])

@php
$colors = [
    'success' => 'bg-green-100 border-green-400 text-green-700',
    'error' => 'bg-red-100 border-red-400 text-red-700',
    'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
];
@endphp

<div class="mb-4 border px-4 py-3 rounded {{ $colors[$type] }}">
    @if($message)
        {{ $message }}
    @elseif($messages)
        <ul class="list-disc list-inside">
            @foreach($messages as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    @else
        {{ $slot }}
    @endif
</div>
