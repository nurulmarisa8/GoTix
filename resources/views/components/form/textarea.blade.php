@props(['name', 'label', 'required' => false, 'placeholder' => '', 'value' => old($name)])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}" 
        @if($required) required @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'form-input']) }}
    >{{ $value }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>