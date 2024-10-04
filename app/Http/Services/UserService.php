<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getUsers()
    {
        try {
            return User::all();
        } catch (\Exception) {
            throw new Exception("Error al consultar los usuarios", 500);
        }
    }

    public function getUserByid($id)
    {
        try {
            return User::find($id);
        } catch (\Exception) {
            throw new Exception("Error al consultar el usuario", 500);
        }
    }

    public function createUser($request)
    {
        try {
            if (!$request->role_id) {
                $role = Role::where("name", "CLIENTE")->first();
                $request->role_id = $role->id;
            }
            return User::create([
                "names" => $request->names,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "lastname" => $request->lastname,
                "date_birth" => $request->date_birth,
                "phone" => $request->phone,
                "address" => $request->address,
                "role_id" => $request->role_id,
            ]);
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function updateUser($request, $id)
    {
        try {
            $user = User::find($id);

            $user->names = $request->names;
            $user->email = $request->email;
            $user->lastname = $request->lastname;
            $user->date_birth = $request->date_birth;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->role_id = $request->role_id;
            $user->status = $request->status;
            $user->save();
        } catch (\Exception) {
            throw new Exception("Error al consultar el usuario", 500);
        }
    }

    public function loginUser($request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                throw new Exception("Credenciales incorrectas", 500);
            }

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw new Exception("Credenciales incorrectas", 500);
            }

            return User::where('users.email', $request->email)
                ->join('roles', 'users.role_id', '=', 'roles.id')
                ->select('users.*', 'roles.name as role_name')
                ->first();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
