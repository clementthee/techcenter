@extends('layouts.panel')

@section('title', 'Ingresar - TechCenter')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="contact-card">
                <h1 class="h3 mb-4">Ingresar</h1>

                @include('partials.social-buttons')

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="email">Correo</label>
                        <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input id="password" class="form-control" type="password" name="password" required>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Entrar</button>
                </form>
                <p class="mt-3 mb-0"><a href="{{ route('register') }}">Crear una cuenta</a></p>
            </div>
        </div>
    </div>
@endsection
