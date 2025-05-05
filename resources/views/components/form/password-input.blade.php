<div class="input-group password-toggle">
    <label for="{{ $name }}">{{ $label }} @if($attributes->has('required'))<span class="text-red-500">*</span>@endif</label>
    <input type="password" name="{{ $name }}" id="{{ $name }}" value="{{ $value ?? '' }}" {{ $attributes->merge(['class' => '']) }} />
    <button type="button" onclick="togglePassword('{{ $name }}', this)">
        <i class="fas fa-eye"></i>
    </button>
    @if(isset($hint))
        <p class="hint-text">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @endif
</div>
