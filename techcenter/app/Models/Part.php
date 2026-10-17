<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function inventoryValue(): float
    {
        return (float) $this->cost * $this->stock;
    }
}
