<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Testimonial;
use App\Models\Producto;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $newMessagesCount = Message::where('respondido', false)->count();

        $recentTestimonialsCount = Testimonial::where('created_at', '>=', now()->subDays(7))->count();

        // Productos con alguna talla cuyo stock sea bajo (menor o igual a 5)
        $lowStockProducts = Producto::select('products.id', 'products.nombre', DB::raw('SUM(product_size.stock) as total_stock'))
            ->join('product_size', 'products.id', '=', 'product_size.product_id')
            ->groupBy('products.id', 'products.nombre')
            ->havingRaw('SUM(product_size.stock) <= ?', [5])
            ->with('sizes')
            ->get();



        $recentPayments = Payment::latest('fecha')
            ->take(5)
            ->get();

        $recentOrders = Order::latest('fecha')
            ->take(5)
            ->get();

        crear_log("Usuario accedido al Dashboard de Administradores");

        return view('admin.dashboard_admin', compact(
            'newMessagesCount',
            'recentTestimonialsCount',
            'lowStockProducts',
            'recentPayments',
            'recentOrders'
        ));
    }
}
