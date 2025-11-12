<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="w-full h-[100vh] flex justify-center items-center bg-[#d20f39]">
    <main class="p-2 flex flex-col w-lg bg-[#eff1f5] h-lg text-[#4c4f69] rounded-md justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-20" alt="Logo" />
            <h1 class="text-2xl text-center font-bold mb-4">Kemurnian School <br />Digital Library</h1>
        </div>

        <form method="POST" action="{{ route('client.login') }}" class="flex flex-col items-center">
            @csrf
            <div class="flex flex-col mb-1">
                <label for="nis" class="text-lg">NIS</label>
                <input id="nis" name="nis" type="text" class="border-1 py-2 px-3 rounded-sm text-xl"
                    value="{{ old('nis') }}" required>
            </div>

            <div class="flex flex-col mb-4">
                <label for="level" class="text-lg">Level</label>
                <select id="level" name="level" class="border-1 py-2 px-3 rounded-sm text-xl w-78" required>
                    <option value="">Select Level</option>
                    <option value="sd" {{ old('level') == 'sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ old('level') == 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ old('level') == 'sma' ? 'selected' : '' }}>SMA</option>
                </select>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <button type="submit"
                class="bg-[#40a02b] p-3 rounded-md text-[#eff1f5] w-72 cursor-pointer hover:bg-[#4db534]">
                Login
            </button>
        </form>
    </main>
</body>

</html>
