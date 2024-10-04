<?php

namespace App\Http\Controllers;

use App\Http\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function index()
    {
        try {
            $services = $this->serviceService->getServices();
            return new JsonResponse($services);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->serviceService->createService($request);
            return new JsonResponse("Servicio creado correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->serviceService->updateService($request, $id);
            return new JsonResponse("Servicio actualizado correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
