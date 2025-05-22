<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="{{ $icon ?? 'fas fa-calendar' }} text-gray-400"></i>
        </div>
        <input type="date" id="{{ $startId ?? 'startDate' }}" name="{{ $startId ?? 'startDate' }}"
            placeholder="{{ $startPlaceholder ?? 'Start Date' }}"
            class="w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            aria-label="Start Date">
    </div>
    <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <i class="{{ $icon ?? 'fas fa-calendar' }} text-gray-400"></i>
        </div>
        <input type="date" id="{{ $endId ?? 'endDate' }}" name="{{ $endId ?? 'endDate' }}"
            placeholder="{{ $endPlaceholder ?? 'End Date' }}"
            class="w-full pl-10 pr-3 py-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
            aria-label="End Date">
    </div>
</div>