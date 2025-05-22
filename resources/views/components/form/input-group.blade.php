<div class="input-group">
    <label for="{{ $name }}">{{ $label }} @if ($attributes->has('required'))
            <span class="text-red-500">*</span>
        @endif
    </label>
    @if ($type === 'select')
        <select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => '']) }}>
            @foreach ($options as $option)
                <option value="{{ $option['value'] }}" {{ $option['selected'] ?? false ? 'selected' : '' }}>
                    {{ $option['label'] }}</option>
            @endforeach
        </select>
    @elseif($type === 'textarea')
        <textarea name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => '']) }}>{{ $value ?? '' }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
            value="{{ $value ?? '' }}" {{ $attributes->merge(['class' => '']) }} />
    @endif
    @if (isset($hint))
        <p class="hint-text">{!! $hint !!}</p>
    @endif
    @error($name)
        <p class="error-text">{{ $message }}</p>
    @enderror
    {{ $slot }}
</div>
