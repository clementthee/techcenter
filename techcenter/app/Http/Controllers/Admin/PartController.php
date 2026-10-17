<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Part;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Catálogo de piezas. Crear y editar también cambia las existencias. */
class PartController extends Controller
{
    /** Lista el catálogo con costo, precio y existencias. */
    public function index(): View
    {
        return view('admin.parts.index', [
            'parts' => Part::query()->orderBy('category')->orderBy('name')->get(),
        ]);
    }

    /** Formulario para una pieza nueva. */
    public function create(): View
    {
        return view('admin.parts.form', [
            'part' => new Part(['stock' => 0]),
        ]);
    }

    /** Guarda la pieza en el inventario. */
    public function store(Request $request): RedirectResponse
    {
        Part::create($this->validated($request));

        return redirect()
            ->route('admin.partes.index')
            ->with('status', 'La parte quedó en el catálogo.');
    }

    /** Formulario para corregir una pieza o sus existencias. */
    public function edit(Part $part): View
    {
        return view('admin.parts.form', [
            'part' => $part,
        ]);
    }

    /** Actualiza la pieza, incluido el stock. */
    public function update(Request $request, Part $part): RedirectResponse
    {
        $part->update($this->validated($request, $part));

        return redirect()
            ->route('admin.partes.index')
            ->with('status', 'El inventario de la parte quedó actualizado.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?Part $part = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Part::CATEGORIES)],
            'sku' => ['required', 'string', 'max:50', Rule::unique('parts', 'sku')->ignore($part)],
            'cost' => ['required', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);
    }
}
