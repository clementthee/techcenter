@extends('layouts.panel')

@section('title', 'Administración - TechCenter')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="section-title mb-0">Estado del negocio</h1>
        <div>
            <a class="btn btn-outline-primary" href="{{ route('admin.partes.index') }}">Catálogo</a>
            <a class="btn btn-primary" href="{{ route('admin.pedidos.index') }}">Pedidos</a>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-3"><div class="contact-card h-100"><p class="text-muted mb-1">Valor del inventario</p><h2>Q {{ number_format($inventoryValue, 2) }}</h2></div></div>
        <div class="col-md-3"><div class="contact-card h-100"><p class="text-muted mb-1">Ventas</p><h2>Q {{ number_format($sales, 2) }}</h2></div></div>
        <div class="col-md-3"><div class="contact-card h-100"><p class="text-muted mb-1">Costos</p><h2>Q {{ number_format($costs, 2) }}</h2></div></div>
        <div class="col-md-3"><div class="contact-card h-100"><p class="text-muted mb-1">Ganancia</p><h2>Q {{ number_format($profit, 2) }}</h2></div></div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="contact-card">
                <h2 class="h5">Ventas, costos y ganancia</h2>
                <canvas id="graficaDinero" class="grafica"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-card">
                <h2 class="h5">Existencias por categoría</h2>
                <canvas id="graficaStock" class="grafica"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="contact-card">
                <h2 class="h5">Pedidos por estado</h2>
                <canvas id="graficaEstados" class="grafica"></canvas>
            </div>
        </div>
    </div>

    <h2 class="h4">Poco stock</h2>
    <div class="contact-card">
        @forelse ($lowStock as $part)
            <p class="mb-1">{{ $part->name }}: {{ $part->stock }} en existencia</p>
        @empty
            <p class="mb-0">Ninguna parte está en 3 unidades o menos.</p>
        @endforelse
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.6/dist/chart.umd.min.js"></script>
    <script>
        new Chart(document.getElementById('graficaDinero'), {
            type: 'bar',
            data: {
                labels: ['Ventas', 'Costos', 'Ganancia'],
                datasets: [{ data: [@json($sales), @json($costs), @json($profit)] }]
            },
            options: { plugins: { legend: { display: false } } }
        });
        new Chart(document.getElementById('graficaStock'), {
            type: 'bar',
            data: {
                labels: Object.keys(@json($stockByCategory)),
                datasets: [{ label: 'Unidades', data: Object.values(@json($stockByCategory)) }]
            }
        });
        new Chart(document.getElementById('graficaEstados'), {
            type: 'doughnut',
            data: {
                labels: @json(array_values(\App\Models\Order::STATUSES)),
                datasets: [{ data: Object.values(@json($byStatus)) }]
            }
        });
    </script>
@endpush
