<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kemurnian School Digital Library</title>
    @vite('resources/css/app.css')
</head>

<body class="flex">
    <x-client.sidebar />
    <div class="bg-white w-full p-2 text-[#171717]">
        @yield('content')
    </div>
</body>

</html>
