@extends('layouts.app')

@section('title', 'Editar perfil | Paddock LATAM')

@section('content')
    <section class="mx-auto min-h-screen w-full max-w-[390px] px-4 pb-10 pt-6 sm:px-5">
        <header class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 rounded-lg text-paddock-muted transition hover:text-paddock-white focus:outline-none focus:ring-2 focus:ring-paddock-red" aria-label="Volver al inicio">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m15 18-6-6 6-6M9 12h12" />
                </svg>
                <span>
                    <span class="block font-mono text-[8px] font-bold uppercase tracking-[0.18em] text-paddock-red">Paddock LATAM</span>
                    <span class="block text-xs font-semibold text-paddock-white">Perfil Piloto</span>
                </span>
            </a>
            <div class="grid size-8 place-items-center rounded-full bg-[#f4a49d] text-[#531510]" aria-hidden="true">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5" />
                    <path d="M5.5 20c.7-3.5 3-5.2 6.5-5.2s5.8 1.7 6.5 5.2" />
                </svg>
            </div>
        </header>

        <div class="mt-4 flex flex-col items-center text-center">
            <div class="relative">
                <img
                    src="{{ asset('images/profile-avatar.jpg') }}"
                    alt="Avatar de {{ old('name', $user->name ?? 'tu perfil') }}"
                    class="size-[76px] rounded-full border-2 border-paddock-border bg-paddock-card object-cover"
                >
                <button type="button" disabled title="La carga de avatar aún no está configurada" class="absolute -bottom-1 -right-1 grid size-7 cursor-not-allowed place-items-center rounded-full border-2 border-paddock-bg bg-paddock-red text-white opacity-90" aria-label="Cambiar avatar">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z" />
                    </svg>
                </button>
            </div>
            <h1 class="mt-2 text-base font-extrabold text-paddock-white">{{ old('name', $user->name ?? 'Tu perfil') }}</h1>
            <p class="mt-1 inline-flex items-center gap-1 rounded-full bg-paddock-card px-2.5 py-1 font-mono text-[8px] font-bold uppercase tracking-wider text-paddock-yellow">
                <span aria-hidden="true">★</span> Fan del Paddock
            </p>
        </div>

        <form class="mt-5 space-y-3" method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            @if (session('status'))
                <p class="rounded-lg border border-paddock-green/30 bg-[#13231d] px-3 py-2 text-xs text-paddock-green" role="status">
                    {{ session('status') }}
                </p>
            @endif

            <fieldset class="rounded-xl border border-paddock-border/60 bg-paddock-card p-3.5">
                <legend class="px-1 font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Datos personales</legend>
                <div class="space-y-3">
                    <x-auth.input-field
                        name="name"
                        label="Nombre completo"
                        placeholder="Tu nombre"
                        autocomplete="name"
                        icon="user"
                        :value="old('name', $user->name ?? '')"
                    />

                    <x-auth.input-field
                        name="handle"
                        label="Nombre de usuario"
                        placeholder="@tu_handle"
                        autocomplete="username"
                        icon="user"
                        :value="old('handle', $user->handle ?? '')"
                        :required="false"
                    />

                    <x-auth.input-field
                        name="email"
                        label="Correo electrónico"
                        type="email"
                        placeholder="fan@paddocklatam.com"
                        autocomplete="email"
                        icon="email"
                        :value="old('email', $user->email ?? '')"
                    />

                    <div>
                        <label for="bio" class="mb-2 block font-mono text-[9px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Biografía</label>
                        <textarea
                            id="bio"
                            name="bio"
                            rows="3"
                            maxlength="280"
                            placeholder="Cuéntanos sobre tu pasión por la F1..."
                            @if ($errors->has('bio')) aria-invalid="true" aria-describedby="bio-error" @endif
                            class="w-full resize-y rounded-lg border bg-paddock-surface px-3 py-2.5 text-xs leading-relaxed text-paddock-white outline-none transition placeholder:text-[#656773] focus:border-paddock-red focus:ring-1 focus:ring-paddock-red {{ $errors->has('bio') ? 'border-paddock-red' : 'border-transparent' }}"
                        >{{ old('bio', $user->bio ?? '') }}</textarea>
                        @error('bio')
                            <p id="bio-error" class="mt-1.5 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-auth.input-field
                        name="city"
                        label="Ciudad"
                        placeholder="Ej. Ciudad de México"
                        autocomplete="address-level2"
                        icon="user"
                        :value="old('city', $user->city ?? '')"
                    />
                </div>
            </fieldset>

            <x-auth.button type="submit" variant="primary">
                <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                </svg>
                Guardar cambios
            </x-auth.button>

            <a href="{{ url('/') }}" class="flex min-h-10 w-full items-center justify-center rounded-lg bg-paddock-card px-3 text-xs font-semibold text-paddock-muted transition hover:text-paddock-white focus:outline-none focus:ring-2 focus:ring-paddock-border">
                Cancelar
            </a>
        </form>

        <button type="button" disabled class="mx-auto mt-4 flex cursor-not-allowed items-center gap-1.5 text-[9px] text-[#e5aaa4] opacity-75">
            <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path d="M10 17l5-5-5-5" />
                <path d="M15 12H3" />
                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
            </svg>
            Cerrar sesión en este dispositivo
        </button>
    </section>
@endsection
