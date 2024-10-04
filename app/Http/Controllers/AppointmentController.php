<?php

namespace App\Http\Controllers;

use App\Http\Services\AppointmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        try {
            $appointments = $this->appointmentService->getAppointments();
            return new JsonResponse($appointments);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function showByUser($id)
    {
        try {
            $appointment = $this->appointmentService->getAppointmentByUserId($id);
            return new JsonResponse($appointment);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->appointmentService->createAppointment($request);
            return new JsonResponse("Cita creada correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $this->appointmentService->updateAppointment($request, $id);
            return new JsonResponse("Cita actualizada correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function complete(Request $request, $id)
    {
        try {
            $this->appointmentService->completeAppointment($request, $id);
            return new JsonResponse("Cita completada correctamente");
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }

    public function count()
    {
        try {
            $appointment = $this->appointmentService->countAppointment();
            return new JsonResponse($appointment);
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 500);
        }
    }
}
