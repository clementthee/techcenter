{{-- Detalle de un ensamble y el control para cambiar su estado. --}}
@extends('layouts.panel')

@section('title', 'Pedido #'.$order->id.' - TechCenter')

@section('content')
    <p><a href="{{ route('admin.pedidos.index') }}">Volver a pedidos</a></p>
    <h1 class="h3">Pedido #{{ $order->id }}</h1>
    <p>Cliente: {{ $order->user->name }} · {{ $order->user->email }}</p>
    @if ($order->notes)
        <p>{{ $order->notes }}</p>
    @endif

    <form class="row g-2 align-items-end mb-4" method="POST" action="{{ route('admin.pedidos.update', $order) }}">
        @csrf
        @method('PATCH')
        <div class="col-md-4">
            <label class="form-label" for="status">Estado del ensamble</label>
            <select id="status" class="form-select" name="status">
                @foreach (\App\Models\Order::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary" type="submit">Actualizar estado</button>
        </div>
    </form>

    <div class="table-responsive contact-card">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Parte</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->part->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Q {{ number_format($item->lineCost(), 2) }}</td>
                        <td>Q {{ number_format($item->lineTotal(), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p class="mt-3">Ganancia de este ensamble: Q {{ number_format($order->total() - $order->cost(), 2) }}</p>
@endsection
