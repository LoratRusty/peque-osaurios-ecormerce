<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Mostrar lista de pagos
    public function index()
    {
        $payments = Payment::with('order')->latest()->paginate(20);
        crear_log('El usuario ha visualizado la lista de pagos.');
        return view('admin.payments', compact('payments'));
    }

    // Mostrar formulario para crear pago nuevo
    public function create()
    {
        $orders = Order::where('status', 'pendiente')->get(); // solo órdenes pendientes
        crear_log('El usuario ha ingresado al formulario para crear un nuevo pago.');
        return view('admin.payments.create', compact('orders'));
    }

    // Guardar nuevo pago
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|in:pendiente,completado,fallido',
            'fecha' => 'required|date',
        ]);

        $payment = Payment::create($request->all());

        crear_log('El usuario ha creado un nuevo pago para la orden #' . $payment->order_id);
        return redirect()->route('payments')->with('success', 'Pago creado correctamente.');
    }

    // Mostrar formulario para editar pago
    public function edit(Payment $payment)
    {
        $orders = Order::where('status', 'pendiente')->orWhere('id', $payment->order_id)->get();
        crear_log('El usuario ha ingresado al formulario para editar el pago #' . $payment->id);
        return view('admin.payments.create', compact('payment', 'orders'));
    }

    // Actualizar pago
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|in:pendiente,completado,fallido',
            'fecha' => 'required|date',
        ]);

        $payment->update($request->all());

        crear_log('El usuario ha actualizado el pago #' . $payment->id);
        return redirect()->route('admin.payments')->with('success', 'Pago actualizado correctamente.');
    }

    // Eliminar pago
    public function destroy(Payment $payment)
    {
        $payment->delete();

        crear_log('El usuario ha eliminado el pago #' . $payment->id);
        return redirect()->route('payments')->with('success', 'Pago eliminado correctamente.');
    }

    // Detalles de un pago
    public function details(Payment $payment)
    {
        $payment->load('order');
        crear_log('El usuario ha visualizado los detalles del pago #' . $payment->id);
        return view('admin.payments.details', compact('payment'));
    }

    // Mostrar factura o recibo del pago
    public function invoice(Payment $payment)
    {
        $payment->load('order');
        crear_log('El usuario ha generado la factura para el pago #' . $payment->id);
        return view('admin.payments.invoice', compact('payment'));
    }
}
