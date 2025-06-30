<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Verifica permisos aquí
            $routeName = $request->route()->getName();
            $permission = str_replace('.', '-', $routeName);
            if (!Auth::user()->hasPermissionTo($permission)) {
                abort(403, 'No tienes permiso para acceder a esta página.');
            }
            return $next($request);
        });
    }
}
