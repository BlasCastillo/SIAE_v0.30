<?php
// En app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $roles = Role::all(); // Obtener todos los roles disponibles
        return view('auth.register', compact('roles')); // Pasar los roles a la vista
    }
}
