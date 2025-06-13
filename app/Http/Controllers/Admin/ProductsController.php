<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Producto::with(['categoria', 'sizes'])->orderBy('created_at', 'desc')->paginate(15);
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas = Size::orderBy('etiqueta')->get();

        crear_log('El usuario ha visualizado el listado de productos.');
        return view('admin.products.products', compact('products', 'categorias', 'tallas'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas = Size::orderBy('etiqueta')->get();

        crear_log('El usuario ha ingresado al formulario para crear un nuevo producto.');
        return view('admin.products.create', compact('categorias', 'tallas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            'categoria_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'imagen' => 'required|image|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'stocks' => 'nullable|array',
            'stocks.*' => 'nullable|integer|min:0',
        ]);

        $producto = new Producto($request->except(['imagen', 'sizes', 'stocks']));

        if ($request->hasFile('imagen')) {
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        } else {
            return redirect()->back()->withErrors(['imagen' => 'La imagen es obligatoria.']);
        }

        $producto->fill($request->except(['imagen', 'sizes', 'stocks']));
        $producto->save();

        $this->syncSizesAndStock($producto, $request);

        crear_log('El usuario ha creado un nuevo producto: ' . $producto->nombre);
        return redirect()->route('admin.products')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $categorias = Categoria::orderBy('nombre')->get();
        $tallas = Size::orderBy('etiqueta')->get();
        $productoTallas = $producto->sizes()->pluck('product_size.stock', 'size_id')->toArray();

        crear_log('El usuario ha ingresado al formulario para editar el producto ID: ' . $id);
        return view('admin.products.edit', compact('producto', 'categorias', 'tallas', 'productoTallas'));
    }

    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'color' => 'nullable|string|max:50',
            'categoria_id' => 'required|exists:categories,id',
            'status' => 'required|boolean',
            'imagen' => 'nullable|image|max:2048',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
            'stocks' => 'nullable|array',
            'stocks.*' => 'nullable|integer|min:0',
        ]);

        $producto->fill($request->except(['imagen', 'sizes', 'stocks']));

        if ($request->hasFile('imagen')) {
            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $producto->save();
        $this->syncSizesAndStock($producto, $request);

        crear_log('El usuario ha actualizado el producto ID: ' . $id);
        return redirect()->route('admin.products')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $producto = Producto::with('sizes')->findOrFail($id);

            $hasOrderItems = DB::table('order_items')->where('product_id', $producto->id)->exists();

            $sizeIds = $producto->sizes->pluck('id')->toArray();
            $hasOrderItemsSizes = false;
            if (!empty($sizeIds)) {
                $hasOrderItemsSizes = DB::table('order_items')->whereIn('size_id', $sizeIds)->exists();
            }

            if ($hasOrderItems || $hasOrderItemsSizes) {
                DB::rollBack();
                crear_log('Intento fallido de eliminar producto ID: ' . $id . ' debido a ventas asociadas.');
                return redirect()->back()->with('error', 'No se puede eliminar el producto porque tiene ventas o pedidos asociados.');
            }

            if ($producto->imagen && Storage::disk('public')->exists($producto->imagen)) {
                Storage::disk('public')->delete($producto->imagen);
            }

            $producto->sizes()->detach();
            $producto->delete();

            DB::commit();
            crear_log('El usuario ha eliminado el producto ID: ' . $id);
            return redirect()->route('admin.products')->with('success', 'Producto eliminado correctamente.');
        } catch (QueryException $qe) {
            DB::rollBack();
            crear_log('Error al eliminar producto ID: ' . $id . '. Mensaje: ' . $qe->getMessage());
            if ($qe->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar el producto porque está asociado a otros registros.');
            }
            return redirect()->back()->with('error', 'Error al eliminar el producto: ' . $qe->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            crear_log('Error inesperado al eliminar producto ID: ' . $id . '. Mensaje: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }

    protected function syncSizesAndStock(Producto $producto, Request $request)
    {
        if ($request->filled('sizes')) {
            $syncData = [];

            foreach ($request->input('sizes') as $sizeId) {
                $stock = $request->input("stocks.$sizeId", 0);
                $syncData[$sizeId] = ['stock' => $stock];
            }

            $producto->sizes()->sync($syncData);
        } else {
            $producto->sizes()->detach();
        }
    }
}
