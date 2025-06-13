<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo email es obligatorio',
            'email.email' => 'Debes ingresar un email válido',
            'message.required' => 'El campo mensaje es obligatorio',
            'message.min' => 'El mensaje debe tener al menos 10 caracteres'
        ]);

        // Guardar en base de datos
        Message::create([
            'nombre' => $validated['name'],
            'email' => $validated['email'],
            'mensaje' => $validated['message'],
        ]);

        // Enviar correo
        Mail::to('soporte@pequenosaurios.com')->send(new ContactMessageMail(
            $validated['name'],
            $validated['email'],
            $validated['message']
        ));

        return response()->json([
            'message' => 'Mensaje enviado correctamente'
        ]);
    }
}
