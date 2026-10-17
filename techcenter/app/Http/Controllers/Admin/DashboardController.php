<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Part;
use Illuminate\View\View;

/** Resumen del negocio: inventario, ventas, costos y ganancia. */
class DashboardController extends Controller
{
    /** Junta los totales que dibujan las gráficas del administrador. */
    public function index(): View
    {
        $parts = Part::query()->orderBy('category')->orderBy('name')->get();
        $items = OrderItem::query()->get();
        $orders = Order::query()->get();

        $sales = $items->sum(fn (OrderItem $item) => $item->lineTotal());
        $costs = $items->sum(fn (OrderItem $item) => $item->lineCost());
        $byStatus = collect(Order::STATUSES)
            ->map(fn (string $label, string $status) => $orders->where('status', $status)->count());
        $stockByCategory = $parts
            ->groupBy('category')
            ->map(fn ($group) => $group->sum('stock'));

        return view('admin.index', [
            'parts' => $parts,
            'inventoryValue' => $parts->sum(fn (Part $part) => $part->inventoryValue()),
            'lowStock' => $parts->filter(fn (Part $part) => $part->stock <= 3)->values(),
            'sales' => $sales,
            'costs' => $costs,
            'profit' => $sales - $costs,
            'byStatus' => $byStatus,
            'stockByCategory' => $stockByCategory,
            'orderCount' => $orders->count(),
        ]);
    }
}
