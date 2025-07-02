<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Producto;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // Estadísticas para el header
        $totalReviews = Review::count();
        $averageRating = Review::avg('puntuacion');

        // Obtener productos para el filtro dropdown
        $products = Producto::select('id', 'nombre')->orderBy('nombre')->get();

        // Consulta base con relaciones
        $reviewsQuery = Review::with(['producto', 'user'])
            ->when($request->filled('searchTerm'), function ($query) use ($request) {
                $search = $request->input('searchTerm');

                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%") // Campo en la tabla de reviews
                        ->orWhere('comentario', 'like', "%$search%") // También en reviews
                        ->orWhereHas('producto', function ($q2) use ($search) { // Relación con productos
                            $q2->where('nombre', 'like', "%$search%");
                        });
                });
            })

            // Filtro por calificación
            ->when($request->filled('selectedRating'), function ($query) use ($request) {
                $query->where('puntuacion', $request->input('selectedRating'));
            })

            // Filtro por producto
            ->when($request->filled('selectedProduct'), function ($query) use ($request) {
                $query->where('producto_id', $request->input('selectedProduct'));
            })

            // Filtro por fecha desde
            ->when($request->filled('dateFrom'), function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->input('dateFrom'));
            })

            // Filtro por fecha hasta
            ->when($request->filled('dateTo'), function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->input('dateTo'));
            })

            // Filtros rápidos de tiempo
            ->when($request->filled('quickFilter'), function ($query) use ($request) {
                $filter = $request->input('quickFilter');
                switch ($filter) {
                    case 'today':
                        $query->whereDate('created_at', today());
                        break;
                    case 'week':
                        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                        break;
                    case 'month':
                        $query->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year);
                        break;
                }
            });

        // Ordenamiento
        $sort = $request->input('selectedSort', 'newest');
        switch ($sort) {
            case 'oldest':
                $reviewsQuery->orderBy('created_at', 'asc');
                break;
            case 'highest':
                $reviewsQuery->orderBy('puntuacion', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'lowest':
                $reviewsQuery->orderBy('puntuacion', 'asc')->orderBy('created_at', 'desc');
                break;
            case 'product':
                $reviewsQuery->join('productos', 'reviews.producto_id', '=', 'productos.id')
                    ->orderBy('productos.nombre', 'asc')
                    ->select('reviews.*');
                break;
            default: // 'newest'
                $reviewsQuery->orderBy('created_at', 'desc');
        }

        // Paginación
        $reviews = $reviewsQuery->paginate(15)->appends(request()->query());

        crear_log('El usuario ha accedido a la vista de Reseñas');

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'averageRating',
            'products'
        ));
    }


    public function show(Review $review)
    {
        $review->load('producto', 'user');
        crear_log("El usuario ha visualizado la reseña ID {$review->id}");
        return view('admin.reviews.show', compact('review'));
    }

    public function destroy(Review $review)
    {
        $review->delete();
        crear_log("El usuario eliminó la reseña ID {$review->id}");
        return redirect()->route('admin.reviews')->with('success', 'Reseña eliminada correctamente.');
    }
}
