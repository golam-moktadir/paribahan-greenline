@props(['locked' => false])

<svg {{ $attributes }} fill="none" stroke="currentColor" viewBox="0 0 24 24">
    @if($locked)
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
    @else
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 11V7a4 4 0 018 0v4m-9 4v5a2 2 0 002 2h6a2 2 0 002-2v-5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
    @endif
</svg>