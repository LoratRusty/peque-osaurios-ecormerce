<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Cart;

class InnvoiceController extends Controller
{    
public function index(Request $request) {
    $query = Order::with('user')->orderBy('created_at', 'desc');
    if ($request->filled('search')) {
        $term = $request->input('search');
        $query->where(function($q) use ($term) {
            $q->where('id', $term)
              ->orWhereHas('user', function($q2) use ($term) {
                  $q2->where('name', 'like', "%{$term}%")
                     ->orWhere('email', 'like', "%{$term}%");
              });
        });
    }
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }
    if ($request->filled('date_from')) {
        $query->whereDate('created_at', '>=', $request->input('date_from'));
    }
    if ($request->filled('date_to')) {
        $query->whereDate('created_at', '<=', $request->input('date_to'));
    }
    if ($request->filled('min_total')) {
        $query->where('total', '>=', $request->input('min_total'));
    }
    if ($request->filled('max_total')) {
        $query->where('total', '<=', $request->input('max_total'));
    }
    $orders = Order::with('user', 'payment.paymentType')->paginate(15);
    // Para carritos pendientes:
    $carts = Cart::with('user','cartItems.product')
                 ->where('status', 'pendiente')
                 ->orderBy('created_at','desc')
                 ->paginate(15, ['*'], 'carts_page');
    return view('admin.invoice.index', compact('orders','carts'));
}

public function updateStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pendiente,procesando,enviado,cancelado,completado',
    ]);
    $order->status = $request->input('status');
    $order->save(); // Solo actualiza el campo 'status'

    return redirect()->back()->with('success', 'Estado actualizado.');
}


}