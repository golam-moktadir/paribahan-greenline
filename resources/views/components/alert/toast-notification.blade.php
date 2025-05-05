@if ($success || $error)
    <div id="toastNotification" class="toast-notification {{ $success ? 'toast-success' : 'toast-error' }}">
        @if ($success)
            <strong class="block font-semibold">Status Updated!</strong>
            <div class="flex items-center gap-1 mt-0.5">
                <span class="font-medium">{{ $success['title'] }}:</span>
                <span class="font-bold">{{ $success['oldStatus'] }}</span>
                <span>→</span>
                <span class="font-bold">{{ $success['newStatus'] }}</span>
            </div>
        @else
            <strong class="block font-semibold">Error:</strong>
            <span>{{ $error }}</span>
        @endif
    </div>
@endif