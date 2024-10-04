<?php

namespace App\Http\Controllers;

use App\Http\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        try {
            $roles = $this->roleService->getRoles();
            return new JsonResponse($roles);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->roleService->createRole($request);
            return new JsonResponse("Rol creado correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->roleService->updateRole($request, $id);
            return new JsonResponse("Rol actualizado correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
