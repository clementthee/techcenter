<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function statusLabel(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function total(): float
    {
        return (float) $this->items->sum(fn (OrderItem $item) => $item->lineTotal());
    }

    public function cost(): float
    {
        return (float) $this->items->sum(fn (OrderItem $item) => $item->lineCost());
    }
}
