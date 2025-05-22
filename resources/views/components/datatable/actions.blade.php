@props([
    'resource' => '',
    'id' => null,
    'item_block' => null,
    'show' => false,
    'edit' => false,
    'delete' => false,
    'block' => false
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

    @if ($delete)
        <form id="delete-{{ $resource }}-form-{{ $id }}"
              action="{{ route($resource . '.destroy', $id) }}"
              method="POST"
              class="inline-block m-0 p-0">
            @csrf
            @method('DELETE')
            <button type="button"
                    onclick="confirmAction('delete', {{ $id }}, '{{ $resource }}', 'delete')"
                    class="p-2 rounded bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 transition"
                    title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endif

    @if ($block)
        <form method="POST" action="{{ route($resource . '.toggle', $id) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded text-sm font-medium transition
               {{ $item_block == 0 ? 'bg-green-100 text-green-700 hover:bg-green-200 hover:text-green-900' : 'bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800' }}" title="{{ $item_block == 0 ? 'Click to Block' : 'Click to Unblock' }}">
        
                @if ($item_block == 0)
                    <i class="fas fa-check"></i>
                    <span>Unblock</span>
                @else
                    <i class="fas fa-ban"></i>
                        <span>Block</span>
                @endif
            </button>
        </form>
    @endif
</div>
