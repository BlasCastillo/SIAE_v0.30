<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; // <-- Añade esta línea
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        Role::create(['name' => $request->input('name')]);
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
    }

   // app/Http/Controllers/RoleController.php

    public function edit($roleId)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::all();

    // Agrupar permisos por la primera parte del nombre, considerando "-" o "."
    $groupedPermissions = $permissions->groupBy(function ($permission) {
        $parts = preg_split('/[-._]/', $permission->name);
        return $parts[0]; // Tomar la primera parte del nombre
    });

        return view('roles.edit', [
            'role' => $role,
            'groupedPermissions' => $groupedPermissions,
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }

public function update(Request $request, $roleId)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'permissions' => 'sometimes|array',
        'permissions.*' => 'exists:permissions,id'
    ]);

    $role = Role::findOrFail($roleId);
    $role->update(['name' => $validated['name']]);

    // Obtener los nombres de los permisos basados en los IDs
    if (isset($validated['permissions'])) {
        $permissionNames = Permission::whereIn('id', $validated['permissions'])
                                    ->pluck('name')
                                    ->toArray();

        $role->syncPermissions($permissionNames);
    } else {
        $role->syncPermissions([]); // Si no hay permisos seleccionados
    }

    return redirect()->route('roles.index')
                   ->with('success', 'Rol actualizado correctamente');
}




public function destroy($roleId)
{
    try {
        // Buscar el rol sin acceder a la relación `users()`
        $role = Role::findOrFail($roleId);

        // Eliminar cualquier referencia en `model_has_roles`
        DB::table('model_has_roles')->where('role_id', $roleId)->delete();

        // Finalmente, eliminar el rol
        $role->delete();

        // Usar session()->flash() en lugar de with()
        session()->flash('success', 'Rol eliminado correctamente');

        return redirect()->route('roles.index');
    } catch (\Exception $e) {
        session()->flash('error', 'No se pudo eliminar el rol: '.$e->getMessage());

        return redirect()->back();
    }
}









}
