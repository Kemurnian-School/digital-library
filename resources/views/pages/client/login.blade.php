<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="w-full h-[100vh] flex justify-center items-center bg-[#d20f39]">
    <main class="p-3 flex flex-col w-lg bg-[#eff1f5] text-[#4c4f69] rounded-md justify-center items-center">
        <div class="flex flex-col items-center">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-20" alt="Logo" />
            <h1 class="text-2xl text-center font-bold mb-4">Kemurnian School <br />Digital Library</h1>
        </div>
        <form method="POST" action="{{ route('client.login') }}" class="flex flex-col items-center">
            @csrf
            <div class="flex flex-col mb-1">
                <label for="nis" class="text-lg">NIS</label>
                <input id="nis" name="nis" type="text" class="border-1 py-2 px-3 rounded-sm text-xl w-72"
                    value="{{ old('nis') }}" required>
                @error('nis')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-1">
                <label for="level" class="text-lg">Level</label>
                <select id="level" name="level" class="border-1 py-2 px-3 rounded-sm text-xl w-72" required>
                    <option value="">Select Level</option>
                    <option value="sd" {{ old('level') == 'sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ old('level') == 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ old('level') == 'sma' ? 'selected' : '' }}>SMA</option>
                </select>
                @error('level')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex flex-col mb-4">
                <label for="password" class="text-lg">Password</label>
                <input id="password" name="password" type="password" class="border-1 py-2 px-3 rounded-sm text-xl w-72"
                    placeholder="Leave blank if not set">
                @error('password')
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
                <span class="text-xs text-gray-600 mt-1">Leave blank if you haven't set a password yet</span>
            </div>
            @if ($errors->any() && !$errors->has('nis') && !$errors->has('level') && !$errors->has('password'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 w-72">
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
        <span class="my-1">or</span>
        <form method="POST" action="{{ route('client.guest') }}" class="w-72">
            @csrf
            <button type="submit" class="flex justify-center items-center bg-[#8c8fa1] p-3 rounded-md text-[#eff1f5] w-full gap-3 cursor-pointer hover:bg-[#9ca0b0]">
                Continue as guest
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path
                        d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM6.02332 15.4163C7.49083 17.6069 9.69511 19 12.1597 19C14.6243 19 16.8286 17.6069 18.2961 15.4163C16.6885 13.9172 14.5312 13 12.1597 13C9.78821 13 7.63095 13.9172 6.02332 15.4163ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z">
                    </path>
                </svg>
            </button>
        </form>
    </main>
</body>
</html>
