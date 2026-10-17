<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Persona que entra a TechCenter.
 * role vale "cliente" o "admin" y decide qué panel se abre después del ingreso.
 */
#[Fillable(['name', 'email', 'password', 'role', 'email_verified_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /** Ensambles que este usuario encargó. */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /** Cuentas de Google, Microsoft o GitHub enlazadas a este usuario. */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /** A dónde va al entrar: el cliente a sus pedidos y el admin al negocio. */
    public function panelRoute(): string
    {
        return $this->role === 'admin' ? route('admin.inicio') : route('cuenta.inicio');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
