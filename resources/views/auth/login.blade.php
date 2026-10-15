@extends('layouts.app')

@section('title', 'Iniciar sesión | Paddock LATAM')

@section('content')
    <section class="mx-auto min-h-screen w-full max-w-[390px] px-5 pb-12 pt-8 sm:px-6">
        <header class="flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 rounded-lg text-paddock-muted transition hover:text-paddock-white focus:outline-none focus:ring-2 focus:ring-paddock-red" aria-label="Volver al inicio">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="m15 18-6-6 6-6M9 12h12" />
                </svg>
                <span>
                    <span class="block font-mono text-[9px] font-bold uppercase tracking-[0.18em] text-paddock-red">Paddock LATAM</span>
                    <span class="block text-sm font-semibold text-paddock-white">Iniciar sesión</span>
                </span>
            </a>

            <div class="grid size-9 place-items-center rounded-full bg-[#f4a49d] text-[#531510]" aria-hidden="true">
                <svg class="size-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5" />
                    <path d="M5.5 20c.7-3.5 3-5.2 6.5-5.2s5.8 1.7 6.5 5.2" />
                </svg>
            </div>
        </header>

        <div class="mt-8 text-center">
            <div class="relative mx-auto grid size-14 place-items-center rounded-xl border-t-2 border-paddock-red bg-paddock-card shadow-[0_10px_30px_rgba(0,0,0,0.3)]">
                <svg class="size-7 text-paddock-red" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M4 17a8 8 0 1 1 16 0v2H4v-2Z" />
                    <path d="m12 15 4-4M7 19h10" />
                </svg>
                <span class="absolute -bottom-1 -right-1 size-3 rounded-full border-2 border-paddock-bg bg-paddock-green"></span>
            </div>
            <p class="mt-3 font-mono text-[9px] font-bold uppercase tracking-[0.2em] text-paddock-yellow">Session telemetry</p>
            <h1 class="mt-1 text-[25px] font-extrabold leading-tight tracking-tight text-paddock-white">Bienvenido de vuelta</h1>
            <p class="mt-2 text-sm text-paddock-muted">Ingresa a tu telemetría y pronósticos de F1</p>
        </div>

        <form class="mt-7 space-y-5" method="POST" action="{{ route('login') }}">
            @csrf

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
                placeholder="Ingresa tu contraseña"
                autocomplete="current-password"
                icon="lock"
            >
                <span aria-disabled="true" title="La recuperación de contraseña aún no está configurada" class="text-[10px] font-semibold text-[#e5aaa4]">
                    ¿Olvidaste tu contraseña?
                </span>
            </x-auth.input-field>

            <label for="remember" class="flex w-fit cursor-pointer items-center gap-2.5 text-xs text-paddock-white">
                <input
                    id="remember"
                    name="remember"
                    type="checkbox"
                    value="1"
                    @checked(old('remember'))
                    class="size-4 rounded border-paddock-border bg-paddock-card text-paddock-green focus:ring-paddock-green focus:ring-offset-paddock-bg"
                >
                <span>Recordar en este dispositivo</span>
            </label>

            <x-auth.button type="submit" variant="primary">
                Iniciar sesión
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </x-auth.button>
        </form>

        <div class="my-5 flex items-center gap-3 text-[9px] font-mono uppercase tracking-[0.15em] text-paddock-muted">
            <span class="h-px flex-1 bg-paddock-border"></span>
            <span>O continúa con</span>
            <span class="h-px flex-1 bg-paddock-border"></span>
        </div>

        <div class="grid grid-cols-2 gap-2">
            <x-auth.button type="button" variant="secondary" :disabled="true" title="El inicio de sesión con Google aún no está configurado">
                <span class="font-bold text-sm text-[#4285f4]" aria-hidden="true">G</span>
                Google
            </x-auth.button>
            <x-auth.button type="button" variant="secondary" :disabled="true" title="El inicio de sesión con Apple aún no está configurado">
                <svg class="size-4 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M16.37 12.18c.02 2.1 1.84 2.8 1.86 2.81-.02.05-.29 1-.96 1.98-.58.85-1.18 1.7-2.13 1.72-.93.02-1.23-.55-2.3-.55s-1.4.53-2.28.57c-.91.03-1.6-.92-2.18-1.76-1.19-1.72-2.1-4.86-.88-6.98.6-1.05 1.67-1.71 2.84-1.73.89-.02 1.73.6 2.28.6.55 0 1.58-.74 2.66-.63.45.02 1.72.18 2.53 1.37-.07.04-1.51.88-1.49 2.6ZM14.62 5.1c.49-.59.82-1.4.73-2.21-.71.03-1.58.47-2.09 1.06-.46.53-.86 1.35-.75 2.15.79.06 1.62-.4 2.11-1Z" />
                </svg>
                Apple
            </x-auth.button>
        </div>

        <p class="mt-6 text-center text-xs text-paddock-muted">
            ¿Aún no tienes cuenta?
            <span aria-disabled="true" title="El registro aún no está configurado" class="font-semibold text-paddock-green">Regístrate en Paddock</span>
        </p>

        <p class="mt-5 flex items-center justify-center gap-2 font-mono text-[8px] uppercase tracking-[0.16em] text-paddock-muted">
            <span class="size-1.5 rounded-full bg-paddock-green"></span>
            LATAM Paddock secure gateway v3.4
        </p>
    </section>
@endsection