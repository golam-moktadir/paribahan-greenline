<div class="input-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="file" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['onchange' => 'previewImage()']) }} />
    <img id="imagePreview" src="#" alt="Image Preview" class="image-preview hidden" />
    @if(isset($hint))
        <p class="hint-text">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @endif
</div>
