<a href="{{ $link }}"
    class="flex flex-col w-68 overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
    <!-- Image Container -->
    <div class="overflow-hidden rounded-t-md">
        <img src="{{ $coverSrc }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>
    <!-- Metadata Container -->
    <div class="bg-white p-4 rounded-b-md flex flex-col justify-between">
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-600">{{ $year }}</span>
            <h2 class="text-lg font-bold text-gray-900 line-clamp-2 mt-1">{{ $title }}</h2>
            <p class="text-sm text-gray-700">{{ $genre }}</p>
        </div>
        <p class="text-sm text-gray-600">by: {{ $author }}</p>
    </div>
</a>
