<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\Cart;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InnvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Construimos la consulta con filtros
        $query = Order::with('user', 'payment.paymentType')->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('id', $term)
                    ->orWhereHas('user', function ($q2) use ($term) {
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

        // Ejecutamos la consulta paginada con los filtros aplicados
        $orders = $query->paginate(15)->appends($request->except('page'));

        // Consulta para carritos pendientes
        $carts = Cart::with('user', 'cartItems.product')
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate(15, ['*'], 'carts_page');

        crear_log('Usuario accedió a la vista de facturación y carritos pendientes');

        return view('admin.invoice.index', compact('orders', 'carts'));
    }


    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pendiente,pagado,enviado,cancelado,completado',
        ]);
        $order->status = $request->input('status');
        $order->save(); // Solo actualiza el campo 'status'

        crear_log("Usuario actualizó el estado de la orden ID {$order->id} a '{$order->status}'");

        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    /**
     * Generar factura en PDF para una orden específica
     */
    public function generateInvoicePDF($orderId)
    {
        // Verificar que la orden pertenece al usuario autenticado
        $orden = Order::where('id', $orderId)
            ->with([
                'orderItems.product',
                'orderItems.size',
                'payment.paymentType',
                'user' // Para obtener datos del usuario
            ])
            ->first();

        $user = $orden->user;

        if (!$orden) {
            abort(404, 'Orden no encontrada');
        }

        // Verificar que la orden tenga un estado que permita generar factura
        if (!in_array($orden->status, ['pagado', 'enviado', 'completado'])) {
            return back()->with('error', 'Solo se pueden generar facturas para órdenes pagadas, enviadas o completadas.');
        }

        // Datos para la factura
        $data = [
            'orden' => $orden,
            'usuario' => $user,
            'fecha_generacion' => Carbon::now(),
            'empresa' => [
                'nombre'    => config('empresa.nombre', 'Mi Tienda'),
                'direccion' => config('empresa.direccion', 'Av. Principal #123'),
                'telefono'  => config('empresa.telefono', '+58 424-0000000'),
                'email'     => config('empresa.email', 'contacto@mitienda.com'),
                'website'   => config('empresa.website', config('app.url'))
            ]
        ];

        // Generar PDF
        $pdf = PDF::loadView('admin.invoice.invoice-pdf', $data);

        // Configurar opciones del PDF
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true
        ]);

        crear_log("Usuario generó la factura PDF de la orden ID {$orden->id}");

        // Nombre del archivo
        $filename = 'factura-orden-' . $orden->id . '-' . Carbon::now()->format('Y-m-d') . '.pdf';

        return $pdf->stream($filename);
    }
}
