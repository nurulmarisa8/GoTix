@props(['name', 'label', 'type' => 'text', 'required' => false, 'placeholder' => '', 'value' => old($name)])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}" 
        value="{{ $value }}"
        @if($required) required @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-input']) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>