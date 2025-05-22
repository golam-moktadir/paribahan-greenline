@props([
    'resource' => '',
    'id' => null,
    'show' => false,
    'edit' => false,
    'booth_block' => null
])

<div class="flex items-center justify-center gap-2">
    @if ($show)
        <a href="{{ route($resource . '.show', $id) }}"
           class="p-2 rounded bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 transition"
           title="View">
            <i class="fas fa-eye"></i>
        </a>
    @endif

    @if ($edit)
        <a href="{{ route($resource . '.edit', $id) }}"
           class="p-2 rounded bg-green-100 text-green-600 hover:bg-green-200 hover:text-green-800 transition"
           title="Edit">
            <i class="fas fa-edit"></i>
        </a>
    @endif
    <form method="POST" action="{{ route($resource . '.toggle', $id) }}">
        @csrf
        @method('PATCH')
        <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium transition
           {{ $booth_block == 1 ? 'bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900' : 'bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800' }}" title="{{ $booth_block == 1 ? 'Unblock this booth' : 'Block this booth' }}">
    
            @if ($booth_block == 1)
                <i class="fas fa-unlock-alt"></i>
                <span>Unblock</span>
            @else
                <i class="fas fa-ban"></i>
                    <span>Block</span>
            @endif
        </button>
    </form>
</div>
