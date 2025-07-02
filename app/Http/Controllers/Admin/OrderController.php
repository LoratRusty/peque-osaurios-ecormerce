<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Lista de órdenes paginadas
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        crear_log('Usuario ha accedido a la vista de Facturas');
        return view('admin.orders.index', compact('orders'));
    }

    // Detalles de una orden específica
    public function details(Order $order)
    {
        $order->load(['user', 'payments', 'items']);
        crear_log("Usuario visualizó detalles de la orden ID {$order->id}");
        return view('admin.orders.details', compact('order'));
    }

    // Mostrar factura de la orden
    public function invoice(Order $order)
    {
        $order->load(['user', 'payments', 'items']);
        crear_log("Usuario visualizó la factura de la orden ID {$order->id}");
        // Pdf para generar la factura
        return view('admin.orders.invoice', compact('order'));
    }
}
