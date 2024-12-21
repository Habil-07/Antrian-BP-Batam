<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Perizinan Berusaha' => [
                'Izin Lokasi',
                'Izin Usaha',
                'Izin Operasional'
            ],
            'Pertanahan' => [
                'Perpanjangan UWTO',
                'Balik Nama UWTO',
                'Pemecahan UWTO'
            ],
            'Properti' => [
                'Sewa Gedung',
                'Sewa Lahan',
                'Pembelian Properti'
            ]
        ];

        $today = Carbon::today();
        $times = [
            '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '13:00', '13:30', '14:00', '14:30', '15:00', '15:30'
        ];

        $statuses = ['waiting', 'called', 'completed'];
        $queueNumber = 1;

        foreach ($services as $mainService => $subServices) {
            foreach ($subServices as $subService) {
                // Generate 2-3 appointments per sub service
                $count = rand(2, 3);
                for ($i = 0; $i < $count; $i++) {
                    $prefix = strtoupper(implode('', array_map(function($word) {
                        return substr($word, 0, 1);
                    }, explode(' ', $mainService))));
                    
                    $queueNum = $prefix . str_pad($queueNumber++, 3, '0', STR_PAD_LEFT);
                    
                    Appointment::create([
                        'main_service' => $mainService,
                        'sub_service' => $subService,
                        'appointment_date' => $today,
                        'appointment_time' => $times[array_rand($times)],
                        'customer_name' => fake()->name(),
                        'customer_nik' => fake()->numerify('################'),
                        'customer_phone' => fake()->phoneNumber(),
                        'queue_prefix' => $prefix,
                        'queue_number' => $queueNum,
                        'status' => $statuses[array_rand($statuses)],
                    ]);
                }
            }
        }
    }
} 