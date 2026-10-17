@extends('layouts.panel')

@section('title', ($part->exists ? 'Editar parte' : 'Nueva parte').' - TechCenter')

@section('content')
    <p><a href="{{ route('admin.partes.index') }}">Volver al catálogo</a></p>
    <div class="col-lg-7">
        <div class="contact-card">
            <h1 class="h3 mb-4">{{ $part->exists ? 'Editar parte' : 'Agregar al inventario' }}</h1>
            <form method="POST" action="{{ $part->exists ? route('admin.partes.update', $part) : route('admin.partes.store') }}">
                @csrf
                @if ($part->exists)
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <label class="form-label" for="name">Nombre</label>
                    <input id="name" class="form-control" name="name" value="{{ old('name', $part->name) }}" required>
                    @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="category">Categoría</label>
                    <select id="category" class="form-select" name="category" required>
                        @foreach (\App\Models\Part::CATEGORIES as $category)
                            <option value="{{ $category }}" @selected(old('category', $part->category) === $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sku">SKU</label>
                    <input id="sku" class="form-control" name="sku" value="{{ old('sku', $part->sku) }}" required>
                    @error('sku')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="cost">Costo</label>
                        <input id="cost" class="form-control" type="number" step="0.01" min="0" name="cost" value="{{ old('cost', $part->cost) }}" required>
                        @error('cost')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="price">Precio</label>
                        <input id="price" class="form-control" type="number" step="0.01" min="0" name="price" value="{{ old('price', $part->price) }}" required>
                        @error('price')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="stock">Existencias</label>
                        <input id="stock" class="form-control" type="number" min="0" name="stock" value="{{ old('stock', $part->stock ?? 0) }}" required>
                        @error('stock')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Guardar</button>
            </form>
        </div>
    </div>
@endsection
