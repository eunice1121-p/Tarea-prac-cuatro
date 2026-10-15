@props([
    'type' => 'button',
    'variant' => 'secondary',
    'disabled' => false,
    'title' => null,
])

@php
    $variantClasses = $variant === 'primary'
        ? 'min-h-12 w-full rounded-lg bg-paddock-red px-5 font-mono text-xs font-bold uppercase tracking-[0.12em] text-white shadow-[0_8px_24px_rgba(225,6,0,0.2)] hover:bg-[#f01810] focus:ring-paddock-red focus:ring-offset-paddock-bg'
        : 'min-h-10 rounded-lg bg-paddock-card px-3 text-xs font-semibold text-paddock-muted';
@endphp

<button
    type="{{ $type }}"
    @disabled($disabled)
    @if ($title) title="{{ $title }}" @endif
    {{ $attributes->class([
        'flex items-center justify-center gap-2 transition focus:outline-none focus:ring-2',
        $variantClasses,
        $disabled ? 'cursor-not-allowed opacity-70' : '',
    ]) }}
>
    {{ $slot }}
</button>
