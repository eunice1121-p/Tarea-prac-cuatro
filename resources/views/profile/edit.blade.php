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
                @if ($user->avatar_path)
                    <img
                        src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($user->avatar_path) }}"
                        alt="Avatar de {{ old('name', $user->name) }}"
                        class="size-[76px] rounded-full border-2 border-paddock-border bg-paddock-card object-cover"
                    >
                @else
                    <div class="grid size-[76px] place-items-center rounded-full border-2 border-paddock-border bg-paddock-card text-xl font-extrabold text-paddock-green" aria-label="Avatar de {{ old('name', $user->name) }}">
                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(old('name', $user->name), 0, 1)) }}
                    </div>
                @endif
                <label for="avatar" class="absolute -bottom-1 -right-1 grid size-7 cursor-pointer place-items-center rounded-full border-2 border-paddock-bg bg-paddock-red text-white transition hover:bg-[#f01810]" aria-label="Cambiar avatar">
                    <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path d="M12 20h9" />
                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z" />
                    </svg>
                </label>
            </div>
            <h1 class="mt-2 text-base font-extrabold text-paddock-white">{{ old('name', $user->name ?? 'Tu perfil') }}</h1>
            <p class="mt-1 inline-flex items-center gap-1 rounded-full bg-paddock-card px-2.5 py-1 font-mono text-[8px] font-bold uppercase tracking-wider text-paddock-yellow">
                <span aria-hidden="true">★</span> Fan del Paddock
            </p>
        </div>

        <form class="mt-5 space-y-3" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" class="sr-only" aria-describedby="avatar-help">
            <p id="avatar-help" class="text-center text-[9px] text-paddock-muted">Avatar JPG, PNG o WebP; máximo 2 MB.</p>
            @error('avatar')
                <p class="text-center text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
            @enderror

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

            <fieldset class="rounded-xl border border-paddock-border/60 bg-paddock-card p-3.5">
                <legend class="px-1 font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Preferencias del Paddock</legend>
                <h2 class="mb-2 font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Zona horaria</h2>
                <div class="grid grid-cols-2 gap-2">
                    <x-auth.country-option name="country" value="mexico" label="México" flag="🇲🇽" timezone="GMT-6" region="CDMX / MTY" :selected="($user->country ?? 'mexico') === 'mexico'" />
                    <x-auth.country-option name="country" value="argentina" label="Argentina" flag="🇦🇷" timezone="GMT-3" region="BS AS / CBA" :selected="($user->country ?? '') === 'argentina'" />
                    <x-auth.country-option name="country" value="colombia" label="Colombia" flag="🇨🇴" timezone="GMT-5" region="BOG / MDE" :selected="($user->country ?? '') === 'colombia'" />
                    <x-auth.country-option name="country" value="chile" label="Chile" flag="🇨🇱" timezone="GMT-4" region="SCL" :selected="($user->country ?? '') === 'chile'" />
                </div>
                @error('country')
                    <p id="country-error" class="mt-1.5 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
                @enderror

                <h2 class="mb-2 mt-4 font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Pilotos favoritos</h2>
                <div class="grid grid-cols-2 gap-x-2 gap-y-2.5">
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Max Verstappen" error-key="favorite_drivers.0" :checked="in_array('Max Verstappen', $user->favorite_drivers ?? [], true) || empty($user->favorite_drivers)">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#1</span> Max Verstappen
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Franco Colapinto" error-key="favorite_drivers.1" :checked="in_array('Franco Colapinto', $user->favorite_drivers ?? [], true)">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#43</span> Franco Colapinto
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Sergio Pérez" error-key="favorite_drivers.2" :checked="in_array('Sergio Pérez', $user->favorite_drivers ?? [], true)">
                        <span class="font-mono text-[9px] font-bold text-paddock-yellow">#11</span> Sergio Pérez
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Fernando Alonso" error-key="favorite_drivers.3" :checked="in_array('Fernando Alonso', $user->favorite_drivers ?? [], true)">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#14</span> Fernando Alonso
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Charles Leclerc" error-key="favorite_drivers.4" :checked="in_array('Charles Leclerc', $user->favorite_drivers ?? [], true)">
                        <span class="font-mono text-[9px] font-bold text-[#ff776f]">#16</span> Charles Leclerc
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Lando Norris" error-key="favorite_drivers.5" :checked="in_array('Lando Norris', $user->favorite_drivers ?? [], true)">
                        <span class="font-mono text-[9px] font-bold text-paddock-yellow">#4</span> Lando Norris
                    </x-auth.checkbox-field>
                </div>
                @error('favorite_drivers')
                    <p id="favorite_drivers-error" class="mt-1.5 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
                @enderror
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

        <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
            @csrf
            <button type="submit" class="inline-flex items-center gap-1.5 text-[9px] text-[#e5aaa4] transition hover:text-white focus:outline-none focus:ring-2 focus:ring-paddock-red">
                <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M10 17l5-5-5-5" />
                    <path d="M15 12H3" />
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
                </svg>
                Cerrar sesión en este dispositivo
            </button>
        </form>
    </section>
@endsection
