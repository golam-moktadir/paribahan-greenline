@props([
    'id',
    'name' => null,
    'options' => [],
    'placeholder' => 'Select an option',
    'value' => null,
    'icon' => null,
])

@php
    $name = $name ?? $id;
    $selected = old($name, $value);
@endphp

<div class="relative">
    @if ($icon)
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
            <i class="{{ $icon }}"></i>
        </span>
    @endif

    <select id="{{ $id }}" name="{{ $name }}"
        class="w-full appearance-none pl-10 pr-8 py-2 rounded-xl border border-gray-300 bg-white text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:outline-none transition">

        <option value="" disabled {{ $selected === null || $selected === '' ? 'selected' : '' }}>
            {{ $placeholder }}
        </option>

        @foreach ($options as $key => $label)
            <option value="{{ $key }}" {{ (string) $selected === (string) $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>

    {{-- Dropdown arrow --}}
    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M19 9l-7 7-7-7" />
        </svg>
    </span>
</div>
