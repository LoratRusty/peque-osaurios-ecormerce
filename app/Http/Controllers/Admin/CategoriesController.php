<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CategoriesController extends Controller
{
    /**
     * Mostrar todas las categorías.
     */
    public function index()
    {
        $categorias = Categoria::orderBy('id', 'asc')->paginate(10); 
        crear_log('El usuario ha accedido al listado de categorías.');
        return view('admin.categories.index', compact('categorias'));
    }

    /**
     * Mostrar formulario para crear una nueva categoría.
     */
    public function create()
    {
        $categoria = new Categoria();
        crear_log('El usuario ha accedido al formulario de creación de una nueva categoría.');
        return view('admin.categories.create', compact('categoria'));
    }

    /**
     * Guardar una nueva categoría.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:categories,nombre',
        ]);

        Categoria::create([
            'nombre' => $request->input('nombre'),
        ]);

        crear_log('El usuario ha creado una nueva categoría: ' . $request->input('nombre'));
        return redirect()->route('admin.products.categories.index')->with('success', 'Categoría creada correctamente.');
    }

    /**
     * Mostrar formulario para editar una categoría existente.
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        crear_log('El usuario ha accedido al formulario de edición de la categoría con ID: ' . $id);
        return view('admin.categories.create', compact('categoria'));
    }

    /**
     * Actualizar una categoría existente.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:100|unique:categories,nombre,' . $categoria->id,
        ]);

        $categoria->update([
            'nombre' => $request->input('nombre'),
        ]);

        crear_log('El usuario ha actualizado la categoría con ID: ' . $id . ' a: ' . $request->input('nombre'));
        return redirect()->route('admin.products.categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    /**
     * Eliminar una categoría.
     */
    public function destroy($id)
    {
        try {
            $categoria = Categoria::findOrFail($id);
            $categoria->delete();

            crear_log('El usuario ha eliminado la categoría con Nombre: ' . $categoria->nombre);
            return redirect()->route('admin.products.categories.index')->with('success', 'Categoría eliminada correctamente.');
        } catch (QueryException $qe) {
            if ($qe->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar la categoría porque está asociada a otros registros.');
            }
            return redirect()->back()->with('error', 'Error al eliminar la categoría: ' . $qe->getMessage());
        }
    }
}
