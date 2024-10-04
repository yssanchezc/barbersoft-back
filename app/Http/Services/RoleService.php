<?php

namespace App\Http\Services;

use App\Models\Role;
use Exception;

class RoleService
{
    public function getRoles()
    {
        try {
            return Role::all();
        } catch (\Exception) {
            throw new Exception("Error al consultar los roles", 500);
        }
    }

    public function createRole($request)
    {
        try {
            Role::create([
                "name" => $request->name
            ]);
        } catch (\Exception) {
            throw new Exception("Error al crear el role", 500);
        }
    }

    public function updateRole($request, $id)
    {
        try {
            $role = Role::find($id);

            if (!$role) {
                throw new Exception("No se encontró el rol", 500);
            }

            $role->name = $request->name;
            $role->status = $request->status;
            $role->save();
        } catch (\Exception) {
            throw new Exception("Error al actualizar el rol", 500);
        }
    }
}
