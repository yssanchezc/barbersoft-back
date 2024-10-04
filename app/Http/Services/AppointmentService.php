<?php

namespace App\Http\Services;

use App\Models\Appointment;
use Exception;
use Illuminate\Support\Facades\DB;

class AppointmentService
{
    public function getAppointments()
    {
        try {
            return Appointment::join('users', 'users.id', '=', 'appointments.client_id')
                ->join('services', 'services.id', '=', 'appointments.service_id')
                ->select(
                    'appointments.*',
                    'services.name as service_name',
                    'services.id as service_id',
                    'services.price',
                    DB::raw("CONCAT(users.names, ' ', users.lastname) as client_name"),
                    'users.id as client_id',
                    DB::raw("COUNT(services.id) as service_count")
                )
                ->groupBy('appointments.id', 'services.name', 'services.id', 'users.names', 'users.lastname', 'users.id')
                ->get();
        } catch (\Exception) {
            throw new Exception("Error al consultar las citas", 500);
        }
    }

    public function getAppointmentByUserId($id)
    {
        try {
            return Appointment::join('services', 'appointments.service_id', '=', 'services.id')
                ->where('appointments.client_id', '=', $id)
                ->select('appointments.*', 'services.name as service_name')
                ->get();
        } catch (\Exception) {
            throw new Exception("Error al consultar las citas del usuario", 500);
        }
    }

    public function createAppointment($request)
    {
        try {
            Appointment::create([
                "date" => $request->date,
                "description" => $request->description,
                "service_id" => $request->service_id,
                "client_id" => $request->client_id
            ]);
        } catch (\Exception) {
            throw new Exception("Error al crear la cita", 500);
        }
    }

    public function updateAppointment($request, $id)
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                throw new Exception("No se encontró la cita", 500);
            }

            $appointment->date = $request->date;
            $appointment->description = $request->description;
            $appointment->service_id = $request->service_id;
            $appointment->client_id = $request->client_id;
            $appointment->status = $request->status;
            $appointment->save();
        } catch (\Exception) {
            throw new Exception("Error al actualizar la cita", 500);
        }
    }

    public function completeAppointment($request, $id)
    {
        try {
            $appointment = Appointment::find($id);

            if (!$appointment) {
                throw new Exception("No se encontró la cita", 500);
            }

            $appointment->status = "REALIZADO";
            $appointment->save();
        } catch (\Exception) {
            throw new Exception("Error al completar la cita", 500);
        }
    }

    public function countAppointment()
    {
        try {
            return Appointment::select(
                DB::raw('COUNT(*) AS total_scheduled'),
                DB::raw('SUM(CASE WHEN status = \'CANCELADO\' THEN 1 ELSE 0 END) AS total_cancelled'),
                DB::raw('SUM(CASE WHEN status = \'REALIZADO\' THEN 1 ELSE 0 END) AS total_completed'),
                DB::raw('SUM(CASE WHEN status = \'PENDIENTE\' THEN 1 ELSE 0 END) AS total_pending'),
                DB::raw('SUM(CASE WHEN created_at != updated_at and status = \'PENDIENTE\' THEN 1 ELSE 0 END) AS total_rescheduled')
            )->first();
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
