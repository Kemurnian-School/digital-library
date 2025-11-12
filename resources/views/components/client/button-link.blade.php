@props([
    'href' => '#',
    'color' => '#e64553',
    'hoverColor' => '#d20f39',
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => "p-2 rounded-sm bg-[{$color}] hover:bg-[{$hoverColor}] cursor-pointer inline-block text-white text-sm font-medium transition",
    ]) }}>
    {{ $slot }}
</a>

