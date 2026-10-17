<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Una pieza dentro de un ensamble.
 * El costo y el precio se guardan aquí para que un cambio futuro del catálogo
 * no reescriba lo que ya se vendió.
 */
class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'part_id',
        'quantity',
        'unit_cost',
        'unit_price',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_cost' => 'decimal:2',
            'unit_price' => 'decimal:2',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    /** Precio de venta de esta línea. */
    public function lineTotal(): float
    {
        return (float) $this->unit_price * $this->quantity;
    }

    /** Costo de esta línea para el taller. */
    public function lineCost(): float
    {
        return (float) $this->unit_cost * $this->quantity;
    }
}
