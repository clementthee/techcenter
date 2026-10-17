<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

/**
 * Ingreso con Google, Microsoft o GitHub.
 * Si el correo ya existe, se enlaza a ese usuario. Si no, se crea un cliente.
 */
class SocialAuthController extends Controller
{
    /** Manda al usuario a la pantalla del proveedor. Si faltan llaves, regresa al login. */
    public function redirect(string $provider): RedirectResponse
    {
        $this->ensureProvider($provider);

        if (blank(config("services.$provider.client_id")) || blank(config("services.$provider.client_secret"))) {
            return redirect()
                ->route('login')
                ->with('social_error', 'El ingreso con '.ucfirst($provider).' todavía no está configurado.');
        }

        $driver = Socialite::driver($provider);

        // GitHub no manda el correo si la cuenta lo tiene privado. Este permiso lo pide aparte.
        if ($provider === 'github') {
            $driver->scopes(['user:email']);
        }

        return $driver->redirect();
    }

    /** Recibe la respuesta del proveedor y abre la sesión. */
    public function callback(string $provider): RedirectResponse
    {
        $this->ensureProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (Throwable) {
            return redirect()
                ->route('login')
                ->with('social_error', 'No se pudo completar el ingreso con '.ucfirst($provider).'.');
        }

        $email = $socialUser->getEmail();

        if (blank($email)) {
            return redirect()
                ->route('login')
                ->with('social_error', ucfirst($provider).' no compartió un correo electrónico.');
        }

        $account = SocialAccount::query()
            ->where('provider', $provider)
            ->where('provider_id', (string) $socialUser->getId())
            ->first();

        if ($account) {
            Auth::login($account->user, remember: true);

            return redirect()->intended($account->user->panelRoute());
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $user = User::create([
                'name' => $socialUser->getName() ?: $socialUser->getNickname() ?: 'Cliente',
                'email' => $email,
                'password' => Str::password(32),
                'role' => 'cliente',
                'email_verified_at' => now(),
            ]);
        }

        $user->socialAccounts()->create([
            'provider' => $provider,
            'provider_id' => (string) $socialUser->getId(),
        ]);

        Auth::login($user, remember: true);

        return redirect()->intended($user->panelRoute());
    }

    /** Solo estos tres nombres son válidos en la URL. */
    private function ensureProvider(string $provider): void
    {
        abort_unless(in_array($provider, ['google', 'microsoft', 'github'], true), 404);
    }
}
