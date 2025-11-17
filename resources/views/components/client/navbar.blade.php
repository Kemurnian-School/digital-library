<nav class="bg-[#dce0e8] px-4 py-2 flex justify-between items-center fixed w-full">
    <section class="flex justify-center items-center gap-3 text-[#4c4f69] font-bold">
        <img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-12" alt="Logo" />
        <h1>Kemurnian School <br />Digital Library</h1>
    </section>
    <section class="flex items-center gap-1">
        <input type="text" placeholder="Search" class="w-86 px-3 py-2 rounded-l-full bg-[#ccd0da]">
        <button class="bg-[#e64553] rounded-r-full py-2 pl-2 pr-3 cursor-pointer">
            <img src="{{ Vite::asset('resources/images/search-line.svg') }}" class="w-6" alt="Logo" />
        </button>
    </section>
    <section class="flex items-center gap-2">
        <div class="flex flex-col">
            @if($isLoggedIn && $nis)
                <div class="flex items-center">
                    <span class="whitespace-nowrap">Welcome! {{ $nis }}</span>
                    <form method="POST" action="{{ route('client.logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-2 hover:opacity-80">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                <path d="M12 2C17.52 2 22 6.48 22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2ZM6.02332 15.4163C7.49083 17.6069 9.69511 19 12.1597 19C14.6243 19 16.8286 17.6069 18.2961 15.4163C16.6885 13.9172 14.5312 13 12.1597 13C9.78821 13 7.63095 13.9172 6.02332 15.4163ZM12 11C13.6569 11 15 9.65685 15 8C15 6.34315 13.6569 5 12 5C10.3431 5 9 6.34315 9 8C9 9.65685 10.3431 11 12 11Z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
                @if($needsPasswordSetup)
                    <button class="bg-[#fe640b] text-white px-3 py-1 rounded-md text-sm hover:bg-[#ff7a2e] cursor-pointer">
                        Set Your Password
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-[#40a02b] text-white px-4 py-2 rounded-md hover:bg-[#4db534]">
                    Login
                </a>
            @endif
        </div>
    </section>
</nav>
