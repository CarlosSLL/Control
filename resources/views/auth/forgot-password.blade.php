@extends('layouts.guest')

@section('content')


 <div class="formulario-login">
        <h1>Recuperar Contraseña</h1>
        <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña</p>
        <form  method="POST" action="{{ route('password.email') }}">
            @csrf
            <label for="email">Correo Electrónico</label>
            <div class="campo-formulario">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                <input type="email" id="email" name="email" placeholder="usuario@empresa.com"  required autofocus>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                @if (session('status'))
                <div class="succes-message">
                    {{ session('status') }}
                </div>
             @endif
            </div>

            <input class="boton-azul" type="submit" value="Restablecer Contraseña">

            <br>
        </form>
        <a class="boton-azul-oscuro" href="{{ route('login') }}">Regresar</a>

    </div>

    @endsection


{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
