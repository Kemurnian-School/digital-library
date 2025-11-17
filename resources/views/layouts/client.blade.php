<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kemurnian School Digital Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>

<body class="flex flex-col bg-[#eff1f5]">
    @unless(request()->is('books/*'))
        <x-client.navbar />
    @endunless

    <div class="w-full p-2 {{ request()->is('books/*') ? '' : 'mt-14' }} text-[#171717]">
        @yield('content')
    </div>
</body>

</html>
