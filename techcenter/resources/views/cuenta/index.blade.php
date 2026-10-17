{{-- Resumen del cliente: gasto, estados de sus ensambles y la lista de pedidos. --}}
@extends('layouts.panel')

@section('title', 'Mis pedidos - TechCenter')

@section('content')
    <h1 class="section-title mb-4">Hola, {{ auth()->user()->name }}</h1>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="contact-card h-100">
                <p class="text-muted mb-1">Gastado en ensambles</p>
                <h2>Q {{ number_format($spent, 2) }}</h2>
            </div>
        </div>
        <div class="col-md-8">
            <div class="contact-card">
                <h2 class="h5">Ensambles por estado</h2>
                <canvas id="graficaEstados" class="grafica"></canvas>
            </div>
        </div>
    </div>

    <h2 class="h4 mb-3">Tus pedidos</h2>
    <div class="table-responsive contact-card">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Pedido</th>
                    <th>Estado</th>
                    <th>Partes</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td><a href="{{ route('cuenta.pedidos.show', $order) }}">#{{ $order->id }}</a></td>
                        <td>{{ $order->statusLabel() }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>Q {{ number_format($order->total(), 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Todavía no tienes ensambles registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('graficaEstados'), {
            type: 'doughnut',
            data: {
                labels: @json(array_values(\App\Models\Order::STATUSES)),
                datasets: [{ data: Object.values(@json($byStatus)) }]
            }
        });
    </script>
@endpush
