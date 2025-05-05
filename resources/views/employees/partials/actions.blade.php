<div class="flex justify-end gap-3">
    <!-- Status Toggle -->
    <form action="{{ route('employees.status.update', $employee->employee_id) }}" method="POST">
        @csrf @method('PUT')
        <button type="submit" class="text-blue-600 hover:text-blue-800 p-1"
            title="{{ $employee->employee_save_status ? 'Block' : 'Unblock' }}">
            <x-icon.lock :locked="$employee->employee_save_status" class="h-5 w-5" />
        </button>
    </form>

    <!-- View -->
    <a href="{{ route('employees.show', $employee->employee_id) }}" class="text-blue-600 hover:text-blue-800 p-1"
        title="View">
        <x-icon.eye class="h-5 w-5" />
    </a>

    <!-- Edit -->
    <a href="{{ route('employees.edit', $employee->employee_id) }}" class="text-indigo-600 hover:text-indigo-800 p-1"
        title="Edit">
        <x-icon.edit class="h-5 w-5" />
    </a>

    <!-- Delete -->
    <form id="delete-form-{{ $employee->employee_id }}"
        action="{{ route('employees.destroy', $employee->employee_id) }}" method="POST">
        @csrf @method('DELETE')
        <button type="button" onclick="confirmDelete({{ $employee->employee_id }})"
            class="text-red-600 hover:text-red-800 p-1" title="Delete">
            <x-icon.trash class="h-5 w-5" />
        </button>
    </form>
</div>