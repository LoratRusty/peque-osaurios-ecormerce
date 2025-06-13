<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class SizesController extends Controller
{
    /**
     * Mostrar todas las sizes.
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->paginate(10);
        crear_log('El usuario ha accedido al listado de tallas.');
        return view('admin.sizes.index', compact('sizes'));
    }

    /**
     * Mostrar formulario para crear una nueva talla.
     */
    public function create()
    {
        $size = new Size();
        crear_log('El usuario ha ingresado al formulario de creación de una nueva talla.');
        return view('admin.sizes.create', compact('size'));
    }

    /**
     * Guardar una nueva talla.
     */
    public function store(Request $request)
    {
        $request->validate([
            'etiqueta' => 'required|string|max:50|unique:sizes,etiqueta',
        ]);

        $size = Size::create([
            'etiqueta' => $request->input('etiqueta'),
        ]);

        crear_log('El usuario ha creado una nueva talla: ' . $size->etiqueta);
        return redirect()->route('admin.products.sizes.index')->with('success', 'Talla creada correctamente.');
    }

    /**
     * Mostrar formulario para editar una talla existente.
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        crear_log('El usuario ha ingresado al formulario de edición de la talla ID: ' . $id);
        return view('admin.sizes.create', compact('size'));
    }

    /**
     * Actualizar una talla existente.
     */
    public function update(Request $request, $id)
    {
        $size = Size::findOrFail($id);

        $request->validate([
            'etiqueta' => 'required|string|max:50|unique:sizes,etiqueta,' . $size->id,
        ]);

        $size->update([
            'etiqueta' => $request->input('etiqueta'),
        ]);

        crear_log('El usuario ha actualizado la talla ID: ' . $id . ' a: ' . $size->etiqueta);
        return redirect()->route('admin.products.sizes.index')->with('success', 'Talla actualizada correctamente.');
    }

    /**
     * Eliminar una talla.
     */
    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $etiqueta = $size->etiqueta;
            $size->delete();

            crear_log('El usuario ha eliminado la talla ID: ' . $id . ' (' . $etiqueta . ')');
            return redirect()->route('admin.products.sizes.index')->with('success', 'Talla eliminada correctamente.');
        } catch (QueryException $qe) {
            crear_log('Error al intentar eliminar la talla ID: ' . $id . '. Mensaje: ' . $qe->getMessage());
            if ($qe->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar la talla porque está asociada a otros registros.');
            }
            return redirect()->back()->with('error', 'Error al eliminar la talla: ' . $qe->getMessage());
        }
    }
}
