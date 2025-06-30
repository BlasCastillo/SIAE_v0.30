<?php
namespace App\Http\Livewire;

// app/Http/Livewire/RoleTable.php
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleTable extends Component
{
    public $roles;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.role-table');
    }
    public function editRole($roleId)
        {
            return redirect()->route('roles.edit', $roleId);
        }

}
