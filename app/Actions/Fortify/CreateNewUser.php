<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'cedula' => ['required', 'string', 'max:9'],
            'cod_telefono' => ['required', 'string', 'max:5'],
            'num_telefono' => ['required', 'string', 'max:8'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role' => ['required', 'exists:roles,name'],
        ])->validate();

        // Crear usuario y guardarlo en una variable
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'cedula' => $input['cedula'],
            'cod_telefono' => $input['cod_telefono'],
            'num_telefono' => $input['num_telefono'],
        ]);

        // Asignar rol (¡Ahora SÍ se ejecuta esta parte!)
        $rolSeleccionado = Role::where('name', $input['role'])->first();
            if ($rolSeleccionado) {
                $user->assignRole($rolSeleccionado);
            }

            return $user; // Retorno correctamente ubicado al final
        }
}
