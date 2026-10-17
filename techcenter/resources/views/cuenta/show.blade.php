@extends('layouts.panel')

@section('title', 'Pedido #'.$order->id.' - TechCenter')

@section('content')
    <p><a href="{{ route('cuenta.inicio') }}">Volver a mis pedidos</a></p>
    <h1 class="h3">Pedido #{{ $order->id }}</h1>
    <p>Estado del ensamble: <strong>{{ $order->statusLabel() }}</strong></p>
    @if ($order->notes)
        <p>{{ $order->notes }}</p>
    @endif

    <div class="table-responsive contact-card">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Parte</th>
                    <th>Categoría</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->part->name }}</td>
                        <td>{{ $item->part->category }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Q {{ number_format($item->lineTotal(), 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>Q {{ number_format($order->total(), 2) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
