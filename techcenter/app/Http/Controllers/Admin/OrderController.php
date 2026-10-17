<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Part;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->with(['user', 'items'])->latest()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.orders.create', [
            'clients' => User::query()->where('role', 'cliente')->orderBy('name')->get(),
            'parts' => Part::query()->where('stock', '>', 0)->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => ['required', Rule::exists('users', 'id')->where('role', 'cliente')],
            'notes' => ['nullable', 'string', 'max:1000'],
            'quantities' => ['nullable', 'array'],
            'quantities.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $selected = collect($data['quantities'] ?? [])
            ->map(fn ($quantity) => (int) $quantity)
            ->filter(fn (int $quantity) => $quantity > 0);

        if ($selected->isEmpty()) {
            throw ValidationException::withMessages([
                'quantities' => 'Agrega al menos una parte al ensamble.',
            ]);
        }

        $order = DB::transaction(function () use ($data, $selected) {
            $order = Order::create([
                'user_id' => $data['user_id'],
                'status' => 'recibido',
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($selected as $partId => $quantity) {
                $part = Part::query()->lockForUpdate()->find($partId);

                if (! $part || $part->stock < $quantity) {
                    throw ValidationException::withMessages([
                        'quantities' => 'No hay suficiente stock de '.($part->name ?? 'esa parte').'.',
                    ]);
                }

                $part->decrement('stock', $quantity);

                $order->items()->create([
                    'part_id' => $part->id,
                    'quantity' => $quantity,
                    'unit_cost' => $part->cost,
                    'unit_price' => $part->price,
                ]);
            }

            return $order;
        });

        return redirect()
            ->route('admin.pedidos.show', $order)
            ->with('status', 'El pedido quedó registrado y el inventario se descontó.');
    }

    public function show(Order $order): View
    {
        $order->load(['user', 'items.part']);

        return view('admin.orders.show', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $order->update(['status' => $data['status']]);

        return redirect()
            ->route('admin.pedidos.show', $order)
            ->with('status', 'El estado del ensamble quedó actualizado.');
    }
}
