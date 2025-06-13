<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $users = $this->filtrarUsuarios($request);
            crear_log('El usuario accedió al listado de usuarios.');

            return view('admin.users.users', compact('users'));
        } catch (\Exception $e) {
            crear_log('Error al acceder al listado de usuarios: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar usuarios: ' . $e->getMessage());
        }
    }

    private function filtrarUsuarios(Request $request)
    {
        $query = \App\Models\User::query();

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query->paginate(50);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'tipo' => 'required|string',
                'status' => 'required|boolean',
                'direccion' => 'nullable|string|max:255',
                'password' => [
                    'nullable',
                    'confirmed',
                    Password::min(8)->mixedCase()->numbers()->symbols(),
                ],
            ], [
                'name.required' => 'El nombre es obligatorio.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'Debe ingresar un correo electrónico válido.',
                'email.unique' => 'Este correo ya está registrado.',
                'tipo.required' => 'El tipo es obligatorio.',
                'status.required' => 'El estado es obligatorio.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'password.min' => 'La contraseña debe tener al menos :min caracteres.',
                'password.mixed_case' => 'La contraseña debe contener mayúsculas y minúsculas.',
                'password.numbers' => 'La contraseña debe incluir al menos un número.',
                'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->tipo = $request->tipo;
            $user->status = $request->status;
            $user->direccion = $request->direccion;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->update();

            crear_log('Se actualizó el usuario ID: ' . $id . ' (' . $user->email . ')');
            return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $ve) {
            return redirect()->back()->withErrors($ve->validator)->withInput();
        } catch (\Exception $e) {
            crear_log('Error al actualizar el usuario ID: ' . $id . '. ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar usuario: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $correo = $user->email;
            $user->delete();

            crear_log('Se eliminó el usuario ID: ' . $id . ' (' . $correo . ')');
            return redirect()->back()->with('success', 'Usuario eliminado correctamente.');
        } catch (QueryException $qe) {
            crear_log('Error al eliminar el usuario ID: ' . $id . '. ' . $qe->getMessage());
            if ($qe->getCode() == 23000) {
                return redirect()->back()->with('error', 'No se puede eliminar el usuario porque está asociado a otros registros.');
            }
            return redirect()->back()->with('error', 'Error al eliminar usuario: ' . $qe->getMessage());
        }
    }

    public function create()
    {
        try {
            crear_log('El usuario accedió al formulario de creación de usuario.');
            return view('admin.users.create_user');
        } catch (\Exception $e) {
            crear_log('Error al cargar el formulario de creación de usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar formulario de creación: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'tipo' => 'required|string',
                'direccion' => 'nullable|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'tipo' => $request->tipo,
                'status' => 1,
                'direccion' => $request->direccion,
                'password' => Hash::make($request->password),
            ]);

            crear_log('Se creó un nuevo usuario: ' . $user->email);
            return redirect()->route('admin.users.users')->with('success', 'Usuario creado correctamente.');
        } catch (ValidationException $ve) {
            return redirect()->back()->withErrors($ve->validator)->withInput();
        } catch (\Exception $e) {
            crear_log('Error al crear usuario: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear usuario: ' . $e->getMessage());
        }
    }
}
