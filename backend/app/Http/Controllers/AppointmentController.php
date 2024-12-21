<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil semua appointment hari ini
            $appointments = Appointment::orderBy('appointment_time')
                ->get();

            // Kelompokkan berdasarkan main_service
            $groupedAppointments = $appointments->groupBy('main_service')->map(function ($group) {
                return $group->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'main_service' => $appointment->main_service,
                        'sub_service' => $appointment->sub_service,
                        'queue_number' => $appointment->queue_number,
                        'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                        'appointment_time' => $appointment->appointment_time->format('H:i'),
                        'status' => $appointment->status,
                        'customer_name' => $appointment->customer_name,
                    ];
                });
            });

            return response()->json([
                'status' => 'success',
                'data' => $groupedAppointments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data antrian'
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'main_service' => 'required|string',
                'sub_service' => 'required|string',
                'appointment_date' => 'required|date',
                'appointment_time' => [
                    'required',
                    'regex:/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/'
                ],
                'customer_name' => 'required|string|max:255',
                'customer_nik' => 'required|string|size:16|regex:/^[0-9]+$/',
                'customer_phone' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'whatsapp' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'queue_prefix' => 'required|string'
            ], [
                'sub_service.required' => 'Sub layanan harus diisi.',
                'sub_service.string' => 'Sub layanan harus berupa teks.',
                'appointment_date.required' => 'Tanggal janji temu harus diisi.',
                'appointment_time.required' => 'Waktu janji temu harus diisi.',
                'appointment_date.after_or_equal' => 'Tanggal harus hari ini atau setelahnya',
                'appointment_time.regex' => 'Format waktu tidak valid',
                'customer_nik.size' => 'NIK harus 16 digit',
                'customer_nik.regex' => 'NIK hanya boleh berisi angka',
                'customer_phone.regex' => 'Format nomor telepon tidak valid',
                'customer_phone.min' => 'Nomor telepon minimal 10 digit'
            ]);

            // Parse dan format tanggal dari ISO string ke Y-m-d
            $appointmentDate = Carbon::parse($validated['appointment_date'])->format('Y-m-d');
            $validated['appointment_date'] = $appointmentDate;

            // Cek ketersediaan slot
            $count = Appointment::where('appointment_date', $appointmentDate)
                ->where('appointment_time', $validated['appointment_time'])
                ->where('main_service', $validated['main_service'])
                ->count();

            if ($count >= 3) {
                throw ValidationException::withMessages([
                    'appointment_time' => ['Slot waktu ini sudah penuh, silakan pilih waktu lain']
                ]);
            }

            $latestQueue = DB::transaction(function () use ($validated) {
                return Appointment::where('main_service', $validated['main_service'])
                    ->where('appointment_date', $validated['appointment_date'])
                    ->latest('queue_number')
                    ->first();
            });

            $queueNumber = $latestQueue 
                ? (int)substr($latestQueue->queue_number, -3) + 1 
                : 1;

            $validated['queue_number'] = $validated['queue_prefix'] . str_pad($queueNumber, 3, '0', STR_PAD_LEFT);
            $validated['status'] = 'waiting';
            
            $appointment = Appointment::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Janji temu berhasil dibuat',
                'queue_number' => $appointment->queue_number,
                'data' => [
                    'id' => $appointment->id,
                    'main_service' => $appointment->main_service,
                    'sub_service' => $appointment->sub_service,
                    'queue_number' => $appointment->queue_number,
                    'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                    'appointment_time' => $appointment->appointment_time->format('H:i'),
                    'customer_name' => $appointment->customer_name,
                    'customer_nik' => $appointment->customer_nik,
                    'customer_phone' => $appointment->customer_phone,
                    'status' => $appointment->status
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal, silakan periksa kembali data yang dimasukkan',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat membuat janji temu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }

    public function checkAvailability(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'time' => 'required',
                'main_service' => 'required|string'
            ]);

            $count = Appointment::where('appointment_date', $validated['date'])
                ->where('appointment_time', $validated['time'])
                ->where('main_service', $validated['main_service'])
                ->count();

            // Maksimal 3 appointment per slot waktu per layanan
            $isAvailable = $count < 3;

            return response()->json([
                'status' => 'success',
                'available' => $isAvailable
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->errors()
            ], 422);
        }
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:waiting,called,completed,cancelled'
            ]);

            $appointment->update([
                'status' => $validated['status']
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Status antrian berhasil diupdate',
                'data' => $appointment
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mengupdate status'
            ], 500);
        }
    }

    public function todayQueue()
    {
        try {
            // Ambil antrian hari ini saja
            $appointments = Appointment::whereDate('appointment_date', Carbon::today())
                ->orderBy('appointment_time')
                ->get();

            // Kelompokkan berdasarkan main_service
            $groupedAppointments = $appointments->groupBy('main_service')->map(function ($group) {
                return $group->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'main_service' => $appointment->main_service,
                        'sub_service' => $appointment->sub_service,
                        'queue_number' => $appointment->queue_number,
                        'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                        'appointment_time' => $appointment->appointment_time->format('H:i'),
                        'status' => $appointment->status,
                        'customer_name' => $appointment->customer_name,
                    ];
                });
            });

            return response()->json([
                'status' => 'success',
                'data' => $groupedAppointments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data antrian'
            ], 500);
        }
    }

    public function allQueue()
    {
        try {
            // Ambil semua appointment diurutkan berdasarkan tanggal dan waktu
            $appointments = Appointment::orderBy('appointment_date')
                ->orderBy('appointment_time')
                ->get();

            // Kelompokkan berdasarkan main_service
            $groupedAppointments = $appointments->groupBy('main_service')->map(function ($group) {
                return $group->map(function ($appointment) {
                    return [
                        'id' => $appointment->id,
                        'main_service' => $appointment->main_service,
                        'sub_service' => $appointment->sub_service,
                        'queue_number' => $appointment->queue_number,
                        'appointment_date' => $appointment->appointment_date->format('Y-m-d'),
                        'appointment_time' => $appointment->appointment_time->format('H:i'),
                        'status' => $appointment->status,
                        'customer_name' => $appointment->customer_name,
                    ];
                });
            });

            return response()->json([
                'status' => 'success',
                'data' => $groupedAppointments
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengambil data antrian'
            ], 500);
        }
    }
}
