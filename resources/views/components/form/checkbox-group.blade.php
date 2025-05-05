<div class="checkbox-group">
    <label>
        <input type="checkbox" name="{{ $name }}" value="{{ $value }}" {{ $checked ? 'checked' : '' }}>
        <span>{{ $label }}</span>
    </label>
    @if(isset($hint))
        <p class="hint-text">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @endif
</div>
