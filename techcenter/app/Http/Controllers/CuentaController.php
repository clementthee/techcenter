<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class CuentaController extends Controller
{
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

    public function show(Order $order): View
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load('items.part');

        return view('cuenta.show', [
            'order' => $order,
        ]);
    }
}
