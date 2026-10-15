@extends('layouts.app')

@section('title', 'Crear cuenta | Paddock LATAM')

@section('content')
    <section class="mx-auto min-h-screen w-full max-w-[390px] px-4 pb-10 pt-6 sm:px-5">
        <header class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 rounded-lg text-paddock-muted transition hover:text-paddock-white focus:outline-none focus:ring-2 focus:ring-paddock-red" aria-label="Volver al inicio">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m15 18-6-6 6-6M9 12h12" />
                </svg>
                <span>
                    <span class="block font-mono text-[8px] font-bold uppercase tracking-[0.18em] text-paddock-red">Paddock LATAM</span>
                    <span class="block text-xs font-semibold text-paddock-white">Registro Paddock</span>
                </span>
            </a>

            <div class="grid size-8 place-items-center rounded-full bg-[#f4a49d] text-[#531510]" aria-hidden="true">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5" />
                    <path d="M5.5 20c.7-3.5 3-5.2 6.5-5.2s5.8 1.7 6.5 5.2" />
                </svg>
            </div>
        </header>

        <div class="mt-5">
            <p class="flex items-center gap-1.5 font-mono text-[8px] font-bold uppercase tracking-[0.17em] text-paddock-green">
                <span class="size-1.5 rounded-full bg-paddock-green"></span>
                Telemetría en directo · LATAM 2025
            </p>
            <h1 class="mt-1 text-[23px] font-extrabold leading-tight tracking-tight text-paddock-white">Crea tu Cuenta Paddock</h1>
            <p class="mt-1 max-w-[340px] text-[11px] leading-relaxed text-paddock-muted">
                Únete a la mayor comunidad de Fórmula 1 en Latinoamérica.
            </p>
        </div>

        <form class="mt-4 space-y-3" method="POST" action="{{ url('/fanid') }}">
            @csrf

            <section class="rounded-xl border border-paddock-border/60 bg-paddock-card p-3.5">
                <div class="mb-3 flex items-center justify-between">
                    <h2 class="font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Paddock // Perfil</h2>
                    <svg class="size-3.5 text-[#e5aaa4]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="8" r="3.5" />
                        <path d="M5.5 20c.7-3.5 3-5.2 6.5-5.2s5.8 1.7 6.5 5.2" />
                    </svg>
                </div>

                <div class="space-y-3">
                    <x-auth.input-field
                        name="nickname"
                        label="Nickname"
                        placeholder="Tu nombre en el paddock"
                        autocomplete="nickname"
                        icon="user"
                        :value="old('nickname')"
                    />

                    <x-auth.input-field
                        name="email"
                        label="Correo electrónico"
                        type="email"
                        placeholder="fan@paddocklatam.com"
                        autocomplete="email"
                        icon="email"
                        :value="old('email')"
                    />

                    <x-auth.input-field
                        name="password"
                        label="Contraseña"
                        type="password"
                        placeholder="Mínimo 8 caracteres"
                        autocomplete="new-password"
                        icon="lock"
                    />
                </div>
            </section>

            <fieldset class="rounded-xl border border-paddock-border/60 bg-paddock-card p-3.5">
                <legend class="sr-only">Selecciona tu zona horaria</legend>
                <div class="mb-2 flex items-center justify-between">
                    <h2 class="font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Paddock // Zona horaria LATAM</h2>
                    <svg class="size-3.5 text-[#e5aaa4]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M3 12h18M12 3a15 15 0 0 1 0 18m0-18a15 15 0 0 0 0 18" />
                    </svg>
                </div>
                <p class="mb-2.5 text-[9px] leading-relaxed text-paddock-muted">
                    Selecciona tu zona horaria para recibir horarios y notificaciones locales.
                </p>

                <div class="grid grid-cols-2 gap-2">
                    <x-auth.country-option name="country" value="mexico" label="México" flag="🇲🇽" timezone="GMT-6" region="CDMX / MTY" />
                    <x-auth.country-option name="country" value="argentina" label="Argentina" flag="🇦🇷" timezone="GMT-3" region="BS AS / CBA" />
                    <x-auth.country-option name="country" value="colombia" label="Colombia" flag="🇨🇴" timezone="GMT-5" region="BOG / MDE" />
                    <x-auth.country-option name="country" value="chile" label="Chile" flag="🇨🇱" timezone="GMT-4" region="SCL" />
                </div>

                @error('country')
                    <p id="country-error" class="mt-2 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
                @enderror
            </fieldset>

            <fieldset class="rounded-xl border border-paddock-border/60 bg-paddock-card p-3.5">
                <legend class="sr-only">Selecciona tus pilotos favoritos</legend>
                <div class="mb-2 flex items-center justify-between gap-2">
                    <h2 class="font-mono text-[8px] font-bold uppercase tracking-[0.15em] text-paddock-muted">Paddock // Pilotos favoritos</h2>
                    <span class="font-mono text-[8px] font-bold uppercase tracking-wider text-paddock-green">Preferencias</span>
                </div>
                <p class="mb-2 text-[9px] leading-relaxed text-paddock-muted">
                    Selecciona tus pilotos favoritos para personalizar noticias y análisis.
                </p>

                <div class="grid grid-cols-2 gap-x-2 gap-y-2.5">
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Max Verstappen" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#1</span> Max Verstappen
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Franco Colapinto" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#43</span> Franco Colapinto
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Sergio Pérez" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-paddock-yellow">#11</span> Sergio Pérez
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Fernando Alonso" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-paddock-green">#14</span> Fernando Alonso
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Charles Leclerc" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-[#ff776f]">#16</span> Charles Leclerc
                    </x-auth.checkbox-field>
                    <x-auth.checkbox-field name="favorite_drivers[]" value="Lando Norris" error-key="favorite_drivers" :show-error="false">
                        <span class="font-mono text-[9px] font-bold text-paddock-yellow">#4</span> Lando Norris
                    </x-auth.checkbox-field>
                </div>

                @error('favorite_drivers')
                    <p id="favorite_drivers-error" class="mt-2 text-xs text-[#ff8b82]" role="alert">{{ $message }}</p>
                @enderror
            </fieldset>

            <x-auth.checkbox-field name="terms" :required="true">
                Acepto los <span class="font-semibold text-paddock-green">Términos de Servicio</span> y deseo recibir notificaciones de Paddock LATAM sobre eventos, análisis y cobertura regional.
            </x-auth.checkbox-field>

            <x-auth.button type="submit" variant="primary">
                Crear cuenta y configurar Paddock
                <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </x-auth.button>
        </form>

        <p class="mt-4 text-center text-[10px] text-paddock-muted">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="font-semibold text-paddock-white underline decoration-paddock-muted underline-offset-2 transition hover:text-paddock-green">
                Inicia sesión
            </a>
        </p>
    </section>
@endsection
