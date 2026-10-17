<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Part;
use App\Models\User;
use Illuminate\Database\Seeder;

/** Datos de prueba: un admin, un cliente, cinco piezas y un ensamble a medio armar. */
class DatabaseSeeder extends Seeder
{
    /**
     * Cuentas locales de demostración. La contraseña de ambas es "password".
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@techcenter.test',
            'password' => 'password',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $client = User::create([
            'name' => 'Ana Cliente',
            'email' => 'cliente@techcenter.test',
            'password' => 'password',
            'role' => 'cliente',
            'email_verified_at' => now(),
        ]);

        $parts = collect([
            ['name' => 'Ryzen 5 5600', 'category' => 'Procesador', 'sku' => 'CPU-5600', 'cost' => 850, 'price' => 1150, 'stock' => 6],
            ['name' => 'RTX 4060', 'category' => 'Tarjeta gráfica', 'sku' => 'GPU-4060', 'cost' => 2100, 'price' => 2650, 'stock' => 4],
            ['name' => 'DDR4 16GB', 'category' => 'Memoria', 'sku' => 'RAM-16', 'cost' => 220, 'price' => 320, 'stock' => 10],
            ['name' => 'SSD 1TB', 'category' => 'Almacenamiento', 'sku' => 'SSD-1TB', 'cost' => 380, 'price' => 520, 'stock' => 8],
            ['name' => 'Fuente 650W', 'category' => 'Fuente', 'sku' => 'PSU-650', 'cost' => 340, 'price' => 480, 'stock' => 2],
        ])->map(fn (array $part) => Part::create($part));

        $order = Order::create([
            'user_id' => $client->id,
            'status' => 'ensamblando',
            'notes' => 'Ensamble de ejemplo para trabajo de oficina.',
        ]);

        foreach (['CPU-5600' => 1, 'RAM-16' => 2, 'SSD-1TB' => 1] as $sku => $quantity) {
            $part = $parts->firstWhere('sku', $sku);
            $part->decrement('stock', $quantity);

            $order->items()->create([
                'part_id' => $part->id,
                'quantity' => $quantity,
                'unit_cost' => $part->cost,
                'unit_price' => $part->price,
            ]);
        }

    }
}
