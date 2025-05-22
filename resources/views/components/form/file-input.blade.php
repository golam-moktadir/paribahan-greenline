<div class="input-group">
    <label for="{{ $name }}">
        {{ $label }}
        @if (!empty($required))
            <span class="text-red-500">*</span>
        @endif
    </label>

    <input type="file" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge([
                'onchange' => 'previewImage()',
            ])->when(!empty($required), fn($attr) => $attr->merge(['required' => 'required'])) }} />

    <img id="imagePreview" src="#" alt="Image Preview" class="image-preview hidden" />

    @if (isset($hint))
        <p class="hint-text">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="error-text">{{ $message }}</p>
    @enderror
</div>
