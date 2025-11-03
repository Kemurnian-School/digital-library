@props([
    'columns' => [],
    'rows' => [],
])

<table class="border border-gray-300 rounded-sm w-xl">
    <thead class="bg-red-600 text-white">
        <tr>
            @foreach ($columns as $col)
                <th class="py-2 px-4 text-left">{{ $col }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody class="text-black">
        @foreach ($rows as $row)
            <tr class="border-t">
                {{-- Label / Field Name --}}
                <td class="py-2 px-4 font-semibold">{{ $row['label'] ?? '' }}</td>

                {{-- Input Generator --}}
                <td class="py-2 px-4">
                    @switch($row['type'])
                        @case('text')
                        @case('number')

                        @case('file')
                            <input type="{{ $row['type'] }}" name="{{ $row['name'] ?? '' }}"
                                placeholder="{{ $row['label'] ?? '' }}" class="border px-2 py-1 rounded w-full" required>
                        @break

                        @case('select')
                            <select name="{{ $row['name'] ?? '' }}" required class="border px-2 py-1 rounded w-full">
                                <option value="">Select {{ $row['label'] ?? '' }}</option>
                                @foreach ($row['options'] ?? [] as $option)
                                    <option value="{{ $option->id ?? ($option['id'] ?? $option) }}">
                                        {{ $option->name ?? ($option['name'] ?? $option) }}
                                    </option>
                                @endforeach
                            </select>
                        @break
                    @endswitch
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
