<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Pieza del catálogo. cost es lo que le cuesta al taller y price es el precio de venta.
 * stock son las existencias que se descuentan al registrar un ensamble.
 */
class Part extends Model
{
    public const CATEGORIES = [
        'Procesador',
        'Tarjeta gráfica',
        'Memoria',
        'Almacenamiento',
        'Placa madre',
        'Fuente',
        'Gabinete',
        'Otro',
    ];

    protected $fillable = [
        'name',
        'category',
        'sku',
        'cost',
        'price',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'decimal:2',
            'price' => 'decimal:2',
            'stock' => 'integer',
        ];
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /** Cuánto dinero hay detenido en esta pieza: costo por existencias. */
    public function inventoryValue(): float
    {
        return (float) $this->cost * $this->stock;
    }
}
