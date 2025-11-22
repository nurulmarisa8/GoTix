@props(['name', 'label', 'required' => false, 'options' => [], 'value' => old($name)])

<div class="mb-4">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <select 
        name="{{ $name }}" 
        id="{{ $name }}" 
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'form-input']) }}
    >
        <option value="">-- Select {{ $label }} --</option>
        @foreach($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" @if($value == $optionValue) selected @endif>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>