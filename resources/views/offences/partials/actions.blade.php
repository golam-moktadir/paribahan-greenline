<div class="flex justify-end gap-3">
    <!-- View -->
    <a href="{{ route('offences.show', $offence->id) }}" class="text-blue-600 hover:text-blue-800 p-1" title="View">
        <x-icon.eye class="h-5 w-5" />
    </a>
    <!-- Edit -->
    <a href="{{ route('offences.edit', $offence->id) }}" class="text-indigo-600 hover:text-indigo-800 p-1" title="Edit">
        <x-icon.edit class="h-5 w-5" />
    </a>
    <!-- Delete -->
    <form id="delete-driver-form-{{ $offence->id }}" action="{{ route('offences.destroy', $offence->id) }}"
        method="POST">
        @csrf @method('DELETE')
        <button type="button" onclick="confirmDelete({{ $offence->id }})" class="text-red-600 hover:text-red-800 p-1"
            title="Delete">
            <x-icon.trash class="h-5 w-5" />
        </button>
    </form>
</div>
