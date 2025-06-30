<?php
namespace Database\Seeders; // Namespace correcto

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Permisos para AULAS
        Permission::create(['name' => 'aulas.index']);
        Permission::create(['name' => 'aulas.create']);
        Permission::create(['name' => 'aulas.edit']);
        Permission::create(['name' => 'aulas.show']);
        Permission::create(['name' => 'aulas.delete']);

        // Permisos para TIPO-AULAS
        Permission::create(['name' => 'tipo-aulas.index']);
        Permission::create(['name' => 'tipo-aulas.create']);
        Permission::create(['name' => 'tipo-aulas.edit']);
        Permission::create(['name' => 'tipo-aulas.show']);
        Permission::create(['name' => 'tipo-aulas.delete']);

        // Permisos para PNFS
        Permission::create(['name' => 'pnfs.index']);
        Permission::create(['name' => 'pnfs.create']);
        Permission::create(['name' => 'pnfs.edit']);
        Permission::create(['name' => 'pnfs.show']);
        Permission::create(['name' => 'pnfs.delete']);

        // Permisos para TRAYECTOS
        Permission::create(['name' => 'trayectos.index']);
        Permission::create(['name' => 'trayectos.create']);
        Permission::create(['name' => 'trayectos.edit']);
        Permission::create(['name' => 'trayectos.show']);
        Permission::create(['name' => 'trayectos.delete']);

        // Permisos para ROLES (incluyendo editName)
        Permission::create(['name' => 'roles.index']);
        Permission::create(['name' => 'roles.create']);
        Permission::create(['name' => 'roles.edit']);
        Permission::create(['name' => 'roles.editName']);
        Permission::create(['name' => 'roles.show']);
        Permission::create(['name' => 'roles.delete']);

        // Permisos para inicio de sesión
        Permission::create(['name' => 'login']);
    }
}
