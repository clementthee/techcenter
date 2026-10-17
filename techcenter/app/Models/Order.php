<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Ensamble de un cliente. El estado recorre recibido, compra de partes,
 * ensamblando, listo y entregado.
 */
class Order extends Model
{
    public const STATUSES = [
        'recibido' => 'Recibido',
        'comprando_partes' => 'Comprando partes',
        'ensamblando' => 'Ensamblando',
        'listo' => 'Listo',
        'entregado' => 'Entregado',
    ];

    protected $fillable = [
        'user_id',
        'status',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Nombre del estado en español, para mostrarlo en pantalla. */
    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /** Suma de lo que el cliente paga por las partes de este ensamble. */
    public function total(): float
    {
        return (float) $this->items->sum(fn (OrderItem $item) => $item->lineTotal());
    }

    /** Suma de lo que esas partes le costaron al taller. */
    public function cost(): float
    {
        return (float) $this->items->sum(fn (OrderItem $item) => $item->lineCost());
    }
}
