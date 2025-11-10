<aside class="bg-red-client min-h-screen px-2 py-4 text-white">
    <nav class="flex flex-col h-full space-y-1">
        <section class="flex justify-center items-center gap-2">
            <img src="{{ Vite::asset('resources/images/logo.PNG') }}" class="w-20 h-20" alt="Logo" />

            <h2 class="flex flex-col text-2xl font-bold">
                <span>Welcome!</span>
                <span>{{ $nis }}</span>
            </h2>

        </section>
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}"
                class="py-2 px-4 w-74 hover:bg-red-500 text-xl rounded-sm
    {{ request()->is(ltrim($link['href'], '/')) || ($link['href'] === '/' && request()->is('/')) ? 'bg-red-client-secondary' : '' }}">
                {{ $link['label'] }}
            </a>
        @endforeach
    </nav>
</aside>
