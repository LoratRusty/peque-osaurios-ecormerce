<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResponseToMessage;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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
        crear_log('El usuario ha borrado el mensaje recibido desde:  ' . $message->email,);

        return redirect()->route('admin.messages')
            ->with('success', 'Mensaje eliminado correctamente.');
    }


    public function respond(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
            'response' => 'required|string|max:1000',
        ]);

        $message = Message::findOrFail($request->message_id);

        // Validar si ya fue respondido
        if ($message->respondido) {
            return redirect()->route('admin.messages')
                ->with('error', 'Este mensaje ya fue respondido previamente.');
        }

        try {
            Mail::to($message->email)->send(new ResponseToMessage($message, $request->response));

            // Verificar fallos en la entrega
            $failures = Mail::failures();
            if (!empty($failures)) {
                return redirect()->route('admin.messages')
                    ->with('error', 'No se pudo enviar el correo a: ' . implode(', ', $failures));
            }
        } catch (TransportExceptionInterface $e) {
            return redirect()->route('admin.messages')
                ->with('error', 'No se pudo enviar el correo: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.messages')
                ->with('error', 'Error inesperado al enviar el correo, contactar a soporte para tener mas detalles');
        }

        // Marcar como respondido si no hubo errores
        $message->respondido = 1;
        $message->save();

        crear_log('El usuario ha respondido el mensaje al correo: ' . $message->email);

        return redirect()->route('admin.messages')
            ->with('success', 'Respuesta enviada y mensaje marcado como respondido.');
    }
}
