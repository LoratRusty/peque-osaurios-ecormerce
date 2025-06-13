<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseToMessage;
class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Message::latest()->paginate(50);

        return view('admin.messages', compact('messages'));
    }

    public function delete($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        crear_log( 'El usuario ha borrado el mensaje recibido desde:  ' . $message->email,);

        return redirect()->route('admin.messages')
            ->with('success', 'Mensaje eliminado correctamente.');
    }


    public function respond(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'message_id' => 'required|exists:messages,id',
            'response' => 'required|string|max:1000',
        ]);

        // Buscar el mensaje
        $message = Message::findOrFail($request->message_id);

        // Enviar el correo de respuesta
        Mail::to($message->email)->send(new ResponseToMessage($message, $request->response));

        // Marcar como respondido y actualizar timestamp
        $message->respondido = 1;
        $message->save(); 

        // Registrar la acción en el log (opcional)
        crear_log( 'El usuario ha repondido el mensaje al correo: ' . $message->email,);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.messages')
            ->with('success', 'Respuesta enviada y mensaje marcado como respondido.');
    }
}
