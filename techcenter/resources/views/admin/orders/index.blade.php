@extends('layouts.panel')

@section('title', 'Pedidos - TechCenter')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Pedidos</h1>
        <a class="btn btn-primary" href="{{ route('admin.pedidos.create') }}">Registrar ensamble</a>
    </div>
    <div class="table-responsive contact-card">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Costo</th>
                    <th>Ganancia</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><a href="{{ route('admin.pedidos.show', $order) }}">#{{ $order->id }}</a></td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->statusLabel() }}</td>
                        <td>Q {{ number_format($order->total(), 2) }}</td>
                        <td>Q {{ number_format($order->cost(), 2) }}</td>
                        <td>Q {{ number_format($order->total() - $order->cost(), 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No hay pedidos.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
