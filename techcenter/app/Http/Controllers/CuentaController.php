<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

/** Lo que ve el cliente después de entrar: sus ensambles, partes y gasto. */
class CuentaController extends Controller
{
    /** Lista los ensambles y arma los números de la gráfica. */
    public function index(): View
    {
        $orders = auth()->user()
            ->orders()
            ->with('items.part')
            ->latest()
            ->get();

        $spent = $orders->sum(fn (Order $order) => $order->total());
        $byStatus = collect(Order::STATUSES)
            ->map(fn (string $label, string $status) => $orders->where('status', $status)->count());

        return view('cuenta.index', [
            'orders' => $orders,
            'spent' => $spent,
            'byStatus' => $byStatus,
        ]);
    }

    /** Detalle de un ensamble. Solo lo puede abrir su dueño. */
    public function show(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.part');

        return view('cuenta.show', [
            'order' => $order,
        ]);
    }
}
