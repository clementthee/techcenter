{{-- Registro de un cliente. También puede usar Google, Microsoft o GitHub. --}}
@extends('layouts.panel')

@section('title', 'Registrarse - TechCenter')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="contact-card">
                <h1 class="h3 mb-4">Crear cuenta</h1>

                @include('partials.social-buttons')

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Nombre</label>
                        <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Correo</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input id="password" class="form-control" type="password" name="password" required>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Registrarme</button>
                </form>
                <p class="mt-3 mb-0"><a href="{{ route('login') }}">Ya tengo cuenta</a></p>
            </div>
        </div>
    </div>
@endsection
