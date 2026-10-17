{{-- Botones de Google, Microsoft y GitHub. Sin llaves se ven igual, pero no redirigen. --}}
@if (session('social_error'))
    <div class="alert alert-warning">{{ session('social_error') }}</div>
@endif

@php
    $proveedores = [
        'google' => [
            'nombre' => 'Google',
            'clase' => 'btn-google',
            'listo' => filled(config('services.google.client_id')) && filled(config('services.google.client_secret')),
        ],
        'microsoft' => [
            'nombre' => 'Microsoft',
            'clase' => 'btn-microsoft',
            'listo' => filled(config('services.microsoft.client_id')) && filled(config('services.microsoft.client_secret')),
        ],
        'github' => [
            'nombre' => 'GitHub',
            'clase' => 'btn-github',
            'listo' => filled(config('services.github.client_id')) && filled(config('services.github.client_secret')),
        ],
    ];
@endphp

<div class="d-grid gap-2">
    @foreach ($proveedores as $clave => $proveedor)
        @if ($proveedor['listo'])
            <a class="btn btn-social {{ $proveedor['clase'] }}" href="{{ route('social.redirect', $clave) }}">
                @include('partials.icono-'.$clave)
                Continuar con {{ $proveedor['nombre'] }}
            </a>
        @else
            <button class="btn btn-social {{ $proveedor['clase'] }}" type="button" disabled>
                @include('partials.icono-'.$clave)
                {{ $proveedor['nombre'] }} todavía no está configurado
            </button>
        @endif
    @endforeach
</div>

<p class="separador-acceso">o entra con tu correo</p>
