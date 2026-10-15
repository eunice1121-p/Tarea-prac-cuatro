@props([
    'name',
    'value' => '1',
    'checked' => false,
    'required' => false,
    'errorKey' => null,
    'showError' => true,
])

@php
    $errorKey = $errorKey ?? $name;
    $oldName = str_replace('[]', '', $name);
    $oldValue = old($oldName);
    $isChecked = is_array($oldValue) ? in_array($value, $oldValue, true) : old($oldName, $checked);
    $inputId = \Illuminate\Support\Str::slug(str_replace(['[]', '[', ']', '.', '_'], '-', $name).'-'.(string) $value);
@endphp

<div>
    <label for="{{ $inputId }}" class="flex cursor-pointer items-start gap-2.5 text-xs leading-relaxed text-paddock-white">
        <input
            id="{{ $inputId }}"
            name="{{ $name }}"
            type="checkbox"
            value="{{ $value }}"
            @checked($isChecked)
            @required($required)
            @if ($errors->has($errorKey)) aria-invalid="true" aria-describedby="{{ $errorKey }}-error" @endif
            class="mt-0.5 size-4 shrink-0 rounded border-paddock-border bg-paddock-card text-paddock-green focus:ring-paddock-green focus:ring-offset-paddock-bg"
        >
        <span>{{ $slot }}</span>
    </label>

    @if ($showError)
        @error($errorKey)
            <p id="{{ $errorKey }}-error" class="mt-1.5 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
        @enderror
    @endif
</div>
