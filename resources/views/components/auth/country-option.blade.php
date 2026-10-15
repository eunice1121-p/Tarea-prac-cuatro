@props([
    'name',
    'value',
    'label',
    'flag',
    'timezone',
    'region',
    'selected' => false,
    'required' => true,
])

<label for="{{ $name }}-{{ $value }}" class="block cursor-pointer">
    <input
        id="{{ $name }}-{{ $value }}"
        type="radio"
        name="{{ $name }}"
        value="{{ $value }}"
        @checked(old($name, $selected) === $value)
        @required($required)
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        class="peer sr-only"
    >
    <span class="flex min-h-[58px] items-center justify-between gap-2 rounded-lg border border-transparent bg-paddock-surface px-3 py-2.5 transition peer-checked:border-paddock-green peer-checked:bg-[#13231d] peer-focus-visible:ring-2 peer-focus-visible:ring-paddock-green">
        <span class="min-w-0">
            <span class="block truncate text-xs font-bold text-paddock-white">{{ $flag }} {{ $label }}</span>
            <span class="mt-1 block font-mono text-[8px] uppercase tracking-wider text-paddock-muted">{{ $region }}</span>
        </span>
        <span class="shrink-0 text-right">
            <span class="block font-mono text-[9px] font-bold text-paddock-green">{{ $timezone }}</span>
            <span class="mt-1 block text-[8px] text-paddock-muted">GMT</span>
        </span>
    </span>
</label>
