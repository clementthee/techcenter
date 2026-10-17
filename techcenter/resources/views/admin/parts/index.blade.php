{{-- Tabla del catálogo. Desde aquí se entra a crear o editar una pieza. --}}
@extends('layouts.panel')

@section('title', 'Catálogo - TechCenter')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Catálogo e inventario</h1>
        <a class="btn btn-primary" href="{{ route('admin.partes.create') }}">Agregar parte</a>
    </div>
    <div class="table-responsive contact-card">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>Parte</th>
                    <th>SKU</th>
                    <th>Categoría</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Existencias</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parts as $part)
                    <tr>
                        <td>{{ $part->name }}</td>
                        <td>{{ $part->sku }}</td>
                        <td>{{ $part->category }}</td>
                        <td>Q {{ number_format($part->cost, 2) }}</td>
                        <td>Q {{ number_format($part->price, 2) }}</td>
                        <td>{{ $part->stock }}</td>
                        <td><a href="{{ route('admin.partes.edit', $part) }}">Editar</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7">El catálogo está vacío.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
