<?php

// app/Http/Livewire/RoleForm.php
namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleForm extends Component
{
    public $role; // Propiedad pública para el rol
    public $permissions; // Propiedad pública para los permisos
    public $selectedPermissions = []; // Propiedad pública para los permisos seleccionados

    public function mount($roleId)
    {
        // Cargar el rol y sus permisos
        $this->role = Role::find($roleId);
        $this->permissions = Permission::all();
        $this->selectedPermissions = $this->role->permissions()->pluck('id')->toArray();
    }

    public function updatePermissions()
    {
        // Sincronizar los permisos seleccionados con el rol
        $this->role->syncPermissions($this->selectedPermissions);
        session()->flash('success', 'Permisos actualizados correctamente');
    }

    public function render()
    {
        return view('livewire.role-form');
    }
}
