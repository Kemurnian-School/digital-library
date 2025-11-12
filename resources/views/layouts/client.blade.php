<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kemurnian School Digital Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col bg-[#eff1f5]">
    <x-client.navbar />
    <div class="w-full p-2 mt-14 text-[#171717]">
        @yield('content')
    </div>
</body>

</html>
