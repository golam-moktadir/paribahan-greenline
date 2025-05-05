<div class="input-group">
    <span class="text-0.75rem font-medium">{{ $label }}</span>
    <div class="radio-group">
        @foreach($options as $option)
            <label>
                <input type="radio" name="{{ $name }}" value="{{ $option['value'] }}" {{ $option['checked'] ? 'checked' : '' }}>
                {{ $option['label'] }}
            </label>
        @endforeach
    </div>
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>