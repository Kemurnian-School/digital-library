<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin {{ $title ?? 'Management' }}</title>
    @vite('resources/css/app.css')
</head>

<body class="flex">
    <x-sidebar />
    <div class="bg-white w-full p-2 text-[#171717]">
        {{ $slot }}
    </div>
</body>

</html>
