<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentType; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;

class PaymentController extends Controller
{
    /**
     * Mostrar listado paginado de métodos de pago
     */
    public function index()
    {
        $payments = PaymentType::orderBy('id', 'desc')->paginate(10);
        crear_log('El usuario ha visualizado el listado de métodos de pago.');
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Mostrar formulario para crear un método de pago
     */
    public function create()
    {
        $payment = new PaymentType();
        crear_log('El usuario ha ingresado al formulario para crear un nuevo método de pago.');
        return view('admin.payments.create', compact('payment'));
    }

    /**
     * Guardar un nuevo método de pago
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|string|max:255|unique:payment_types,nombre',
            'descripcion' => 'nullable|string|max:1000',
            'status' => 'required|boolean',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            crear_log('Error al validar datos al crear método de pago.');
            return redirect()->route('admin.payments.create')
                ->withErrors($validator)
                ->withInput();
        }

        PaymentType::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        crear_log('El usuario ha creado un nuevo método de pago: ' . $request->nombre);
        return redirect()->route('admin.payments')
            ->with('success', 'Método de pago creado correctamente.');
    }

    /**
     * Mostrar formulario para editar un método de pago existente
     */
    public function edit($id)
    {
        $payment = PaymentType::findOrFail($id);
        crear_log('El usuario ha ingresado al formulario para editar el método de pago ID: ' . $id);
        return view('admin.payments.create', compact('payment'));
    }

    /**
     * Actualizar un método de pago existente
     */
    public function update(Request $request, $id)
    {
        $payment = PaymentType::findOrFail($id);

        $rules = [
            'nombre' => 'required|string|max:255|unique:payment_types,nombre,' . $payment->id,
            'descripcion' => 'nullable|string|max:1000',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            crear_log('Error al validar datos al actualizar el método de pago ID: ' . $id);
            return redirect()->route('admin.payments.create', $payment->id)
                ->withErrors($validator)
                ->withInput();
        }

        $payment->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'status' => $request->has('status') ? 1 : 0,
        ]);

        crear_log('El usuario ha actualizado el método de pago ID: ' . $id);
        return redirect()->route('admin.payments')
            ->with('success', 'Método de pago actualizado correctamente.');
    }

    /**
     * Eliminar un método de pago
     */
    public function destroy($id)
    {
        try {
            $payment = PaymentType::findOrFail($id);
            $payment->delete();

            crear_log('El usuario ha eliminado el método de pago ID: ' . $ $payment->nombre);
            return redirect()->route('admin.payments')
                ->with('success', 'Método de pago eliminado correctamente.');
        } catch (QueryException $qe) {
            crear_log('Error al eliminar método de pago ID: ' . $id . '. Mensaje: ' . $qe->getMessage());

            if ($qe->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar el método de pago porque está asociado a otros registros.');
            }

            return redirect()->back()->with('error', 'Error al eliminar el método de pago: ' . $qe->getMessage());
        }
    }
}
