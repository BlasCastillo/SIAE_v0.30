<?php
// database/seeders/RolesAndPermissionsSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Truncar tablas relacionadas con permisos y roles
        Permission::truncate();
        Role::truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        // Reset cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles
        $this->createRole('USUARIO');
        $this->createRole('DOCENTE');
        $this->createRole('COORDINADOR');
        $this->createRole('DIRECTOR');
        $this->createRole('ADMINISTRADOR');

        // Crear permisos
        $this->createPermissions();

        // Asignar permisos a roles
        $this->assignPermissionsToRoles();

        // Actualizar caché
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }

    private function createRole($name)
    {
        if (!Role::where('name', $name)->exists()) {
            Role::create(['name' => $name]);
        }
    }

    private function createPermissions()
    {
            // Permisos para AULAS
            $this->createPermission('aulas.index');
            $this->createPermission('aulas.create');
            $this->createPermission('aulas.edit');
            $this->createPermission('aulas.show');
            $this->createPermission('aulas.update');
            $this->createPermission('aulas.store');
            $this->createPermission('aulas.destroy');

            // Permisos para TIPO-AULAS
            $this->createPermission('tipo-aulas.index');
            $this->createPermission('tipo-aulas.create');
            $this->createPermission('tipo-aulas.edit');
            $this->createPermission('tipo-aulas.update');
            $this->createPermission('tipo-aulas.store');
            $this->createPermission('tipo-aulas.show');
            $this->createPermission('tipo-aulas.destroy');

             // Permisos para TIPO-UNIDADES-CURRICULARES
            $this->createPermission('tipo-unidades-curriculares.index');
            $this->createPermission('tipo-unidades-curriculares.create');
            $this->createPermission('tipo-unidades-curriculares.edit');
            $this->createPermission('tipo-unidades-curriculares.update');
            $this->createPermission('tipo-unidades-curriculares.store');
            $this->createPermission('tipo-unidades-curriculares.show');
            $this->createPermission('tipo-unidades-curriculares.destroy');

            // Permisos para PNFS
            $this->createPermission('pnfs.index');
            $this->createPermission('pnfs.create');
            $this->createPermission('pnfs.edit');
            $this->createPermission('pnfs.update');
            $this->createPermission('pnfs.store');
            $this->createPermission('pnfs.show');
            $this->createPermission('pnfs.destroy');

            // Permisos para TRAYECTOS
            $this->createPermission('trayectos.index');
            $this->createPermission('trayectos.create');
            $this->createPermission('trayectos.edit');
            $this->createPermission('trayectos.update');
            $this->createPermission('trayectos.store');
            $this->createPermission('trayectos.show');
            $this->createPermission('trayectos.destroy');

            // Permisos para SECCIONES
            $this->createPermission('secciones.index');
            $this->createPermission('secciones.create');
            $this->createPermission('secciones.edit');
            $this->createPermission('secciones.update');
            $this->createPermission('secciones.store');
            $this->createPermission('secciones.show');
            $this->createPermission('secciones.destroy');

            // Permisos para ROLES
            $this->createPermission('roles.index');
            $this->createPermission('roles.create');
            $this->createPermission('roles.edit');
            $this->createPermission('roles.show');
            $this->createPermission('roles.update');
            $this->createPermission('roles.store');
            $this->createPermission('roles.destroy');

            // Permisos para inicio de sesión
            $this->createPermission('login');

            // Permisos para Dashboard
            $this->createPermission('dashboard');
        }

        private function assignPermissionsToRoles()
        {
            // Asignar permisos al rol USUARIO
            $userRole = Role::where('name', 'USUARIO')->first();
            $userRole->givePermissionTo([
                'dashboard',
            ]);

            // Asignar permisos al rol DOCENTE
            $docenteRole = Role::where('name', 'DOCENTE')->first();
            $docenteRole->givePermissionTo([
                'login',
                'aulas.index',
                'aulas.show',
                'pnfs.index',
                'pnfs.show',
            ]);

            // Asignar permisos al rol COORDINADOR
            $coordinadorRole = Role::where('name', 'COORDINADOR')->first();
            $coordinadorRole->givePermissionTo([
                'login',
                'dashboard',
                'aulas.index',
                'aulas.create',
                'aulas.store',
                'aulas.edit',
                'aulas.update',
                'aulas.show',
                'aulas.destroy',
                'pnfs.index',
                'pnfs.create',
                'pnfs.store',
                'pnfs.edit',
                'pnfs.update',
                'pnfs.show',
                'pnfs.destroy',
                'trayectos.index',
                'trayectos.create',
                'trayectos.store',
                'trayectos.edit',
                'trayectos.update',
                'trayectos.show',
                'trayectos.destroy',
            ]);

            // Asignar permisos al rol DIRECTOR
            $directorRole = Role::where('name', 'DIRECTOR')->first();
            $directorRole->givePermissionTo([
                'login',
                'dashboard',
                'aulas.index',
                'aulas.create',
                'aulas.store',
                'aulas.edit',
                'aulas.update',
                'aulas.show',
                'aulas.destroy',
                'pnfs.index',
                'pnfs.create',
                'pnfs.store',
                'pnfs.edit',
                'pnfs.update',
                'pnfs.show',
                'pnfs.destroy',
                'trayectos.index',
                'trayectos.create',
                'trayectos.store',
                'trayectos.edit',
                'trayectos.update',
                'trayectos.show',
                'trayectos.destroy',
            ]);

            // Asignar permisos al rol ADMINISTRADOR
            $adminRole = Role::where('name', 'ADMINISTRADOR')->first();
            $adminRole->givePermissionTo([
                'login',
                'dashboard',
                'roles.index',
                'roles.create',
                'roles.store',
                'roles.edit',
                'roles.update',
                'roles.show',
                'roles.destroy',
                'aulas.index',
                'aulas.create',
                'aulas.store',
                'aulas.edit',
                'aulas.update',
                'aulas.show',
                'aulas.destroy',
                'tipo-aulas.index',
                'tipo-aulas.create',
                'tipo-aulas.store',
                'tipo-aulas.edit',
                'tipo-aulas.update',
                'tipo-aulas.show',
                'tipo-aulas.destroy',
                'pnfs.index',
                'pnfs.create',
                'pnfs.store',
                'pnfs.edit',
                'pnfs.update',
                'pnfs.show',
                'pnfs.destroy',
                'trayectos.index',
                'trayectos.create',
                'trayectos.store',
                'trayectos.edit',
                'trayectos.update',
                'trayectos.show',
                'trayectos.destroy',
            ]);
        }


    private function createPermission($name)
    {
        if (!Permission::where('name', $name)->exists()) {
            Permission::create(['name' => $name]);
        }
    }
}
