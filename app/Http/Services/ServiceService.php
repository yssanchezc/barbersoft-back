<?php

namespace App\Http\Services;

use App\Models\Service;
use Exception; 

class ServiceService
{
    public function getServices()
    {
        try {
            return Service::where('status', true)->get();
        } catch (\Exception) {
            throw new Exception("Error al consultar los servicios", 500);
        }
    }

    public function createService($request)
    {
        try {
            Service::create([
                "name" => $request->name,
                "price" => $request->price
            ]);
        } catch (\Exception) {
            throw new Exception("Error al crear el servicio", 500);
        }
    }

    public function updateService($request, $id)
    {
        try {
            $service = Service::find($id);

            if (!$service) {
                throw new Exception("No se encontró el servicio", 500);
            }

            $service->name = $request->name;
            $service->price = $request->price;
            $service->status = $request->status;
            $service->save();
        } catch (\Exception) {
            throw new Exception("Error al actualizar el servicio", 500);
        }
    }
}
