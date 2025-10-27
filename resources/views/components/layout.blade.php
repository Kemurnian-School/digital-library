<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin {{ $title ?? 'Management'}}</title>
        @vite('resources/css/app.css')
    </head>
    <body>
        <x-sidebar/>
        {{ $slot }}
    </body>
</html>
