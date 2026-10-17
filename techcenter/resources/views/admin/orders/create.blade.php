@extends('layouts.panel')

@section('title', 'Nuevo pedido - TechCenter')

@section('content')
    <p><a href="{{ route('admin.pedidos.index') }}">Volver a pedidos</a></p>
    <div class="contact-card">
        <h1 class="h3 mb-4">Registrar ensamble</h1>
        <form method="POST" action="{{ route('admin.pedidos.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="user_id">Cliente</label>
                <select id="user_id" class="form-select" name="user_id" required>
                    <option value="">Selecciona un cliente</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected(old('user_id') == $client->id)>{{ $client->name }} · {{ $client->email }}</option>
                    @endforeach
                </select>
                @error('user_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="notes">Notas</label>
                <textarea id="notes" class="form-control" name="notes" rows="2">{{ old('notes') }}</textarea>
            </div>
            <h2 class="h5">Partes</h2>
            @error('quantities')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
            @forelse ($parts as $part)
                <div class="row align-items-center mb-2">
                    <div class="col-md-8">{{ $part->name }} · hay {{ $part->stock }} · Q {{ number_format($part->price, 2) }}</div>
                    <div class="col-md-4">
                        <input class="form-control" type="number" min="0" max="{{ $part->stock }}" name="quantities[{{ $part->id }}]" value="{{ old('quantities.'.$part->id, 0) }}">
                    </div>
                </div>
            @empty
                <p>No hay partes con existencia. Agrega inventario primero.</p>
            @endforelse
            <button class="btn btn-primary mt-3" type="submit">Guardar pedido</button>
        </form>
    </div>
@endsection
