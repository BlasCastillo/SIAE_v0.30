<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get(); // ✅ Obtener usuarios con su rol
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create'); // ✅ No es necesario seleccionar el rol, siempre será "DOCENTE"
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|min:8|confirmed',
        'cedula' => 'required|string|max:9|unique:users', // ✅ Laravel validará antes de tocar la BD
        'cod_telefono' => 'required|string|max:5',
        'num_telefono' => 'required|string|max:8',
    ]);

    try {
        $role = Role::where('name', 'DOCENTE')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cedula' => $request->cedula,
            'cod_telefono' => $request->cod_telefono,
            'num_telefono' => $request->num_telefono,
            'role_id' => $role->id,
        ]);

        if ($role) {
            $user->assignRole($role);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente con rol DOCENTE');
    } catch (\Exception $e) {
        return back()->withErrors(['cedula' => 'La cédula ingresada ya está registrada.']);
    }
}


    public function edit(User $user)
    {
        // 🔥 Evita que el usuario en sesión edite su propio perfil
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'No puedes editar tu perfil mientras la sesión está activa.');
        }

        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // 🔥 Evita que el usuario en sesión se modifique a sí mismo
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'No puedes modificar tu perfil mientras la sesión está activa.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        $role = Role::find($request->role_id);
        if ($role) {
            $user->syncRoles([$role->name]); // ✅ El usuario cambia de rol si se edita
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        // 🔥 Evita que el usuario en sesión se elimine a sí mismo
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'No puedes eliminar tu usuario mientras la sesión está activa.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }


}
