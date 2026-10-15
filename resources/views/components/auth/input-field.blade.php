@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => 'off',
    'icon' => 'email',
    'value' => null,
    'required' => true,
])

<div>
    <div class="mb-2 flex min-h-4 items-center justify-between gap-3">
        <label for="{{ $name }}" class="font-mono text-[9px] font-bold uppercase tracking-[0.15em] text-paddock-muted">
            {{ $label }}
        </label>
        @if ($slot->isNotEmpty())
            <div>{{ $slot }}</div>
        @endif
    </div>

    <div class="relative">
        <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-paddock-muted" aria-hidden="true">
            @if ($icon === 'lock')
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="5" y="10" width="14" height="11" rx="2" />
                    <path d="M8 10V7a4 4 0 1 1 8 0v3m-4 4v3" />
                </svg>
            @elseif ($icon === 'user')
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5" />
                    <path d="M5.5 20c.7-3.5 3-5.2 6.5-5.2s5.8 1.7 6.5 5.2" />
                </svg>
            @else
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="5" width="18" height="14" rx="2" />
                    <path d="m4 7 8 6 8-6" />
                </svg>
            @endif
        </span>

        <input
            id="{{ $name }}"
            name="{{ $name }}"
            type="{{ $type }}"
            value="{{ $value ?? ($type === 'password' ? '' : old($name)) }}"
            placeholder="{{ $placeholder }}"
            autocomplete="{{ $autocomplete }}"
            @if ($type === 'password') data-password-input @endif
            @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
            @required($required)
            class="min-h-11 w-full rounded-lg border bg-paddock-card py-2.5 pl-10 pr-11 text-sm text-paddock-white outline-none transition placeholder:text-[#656773] focus:border-paddock-red focus:ring-1 focus:ring-paddock-red {{ $errors->has($name) ? 'border-paddock-red' : 'border-transparent' }}"
        >

        @if ($type === 'password')
            <button
                type="button"
                data-password-toggle
                aria-controls="{{ $name }}"
                aria-label="Mostrar contraseña"
                aria-pressed="false"
                class="absolute inset-y-0 right-3 flex items-center text-paddock-muted transition hover:text-paddock-white focus:outline-none focus:ring-2 focus:ring-paddock-red"
            >
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z" />
                    <circle cx="12" cy="12" r="3" />
                </svg>
            </button>
        @endif
    </div>

    @error($name)
        <p id="{{ $name }}-error" class="mt-1.5 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
    @enderror
</div>
