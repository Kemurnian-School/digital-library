<aside class="bg-red-primary min-h-screen px-2 py-4 text-white">
    <nav class="flex flex-col h-full space-y-1">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}"
                class="py-2 px-4 w-48 hover:bg-red-500 rounded-sm {{ request()->is(ltrim($link['href'], '/')) ? 'bg-red-600' : '' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</aside>

