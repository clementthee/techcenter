@if (session('social_error'))
    <div class="alert alert-warning">{{ session('social_error') }}</div>
@endif

@php
    $googleListo = filled(config('services.google.client_id')) && filled(config('services.google.client_secret'));
    $microsoftListo = filled(config('services.microsoft.client_id')) && filled(config('services.microsoft.client_secret'));
@endphp

<div class="d-grid gap-2 mb-3">
    @if ($googleListo)
        <a class="btn btn-outline-dark" href="{{ route('social.redirect', 'google') }}">Continuar con Google</a>
    @else
        <button class="btn btn-outline-dark" type="button" disabled>Google todavía no está configurado</button>
    @endif

    @if ($microsoftListo)
        <a class="btn btn-outline-primary" href="{{ route('social.redirect', 'microsoft') }}">Continuar con Microsoft</a>
    @else
        <button class="btn btn-outline-primary" type="button" disabled>Microsoft todavía no está configurado</button>
    @endif
</div>
