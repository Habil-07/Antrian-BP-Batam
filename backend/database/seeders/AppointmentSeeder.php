<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        // Hapus data yang ada
        Appointment::truncate();

        $startDate = Carbon::now();
        $endDate = Carbon::now()->addDays(30);
        $queueCounter = 1;

        $times = [
            '08:00', '08:30', '09:00', '09:30', '10:00', '10:30',
            '11:00', '11:30', '13:00', '13:30', '14:00', '14:30',
            '15:00', '15:30'
        ];

        $statuses = ['waiting'];
        $firstNames = ['Budi', 'Siti', 'Ahmad', 'Dewi', 'Rudi', 'Nina', 'Andi', 'Maya'];
        $lastNames = ['Santoso', 'Wijaya', 'Kusuma', 'Pratama', 'Sari', 'Putri', 'Hidayat'];

        foreach (AllServicesData::$services as $serviceGroup) {
            $queuePrefix = AllServicesData::getQueuePrefix($serviceGroup['service']);
            
            foreach ($serviceGroup['subServices'] as $subService) {
                // Generate 2-5 appointments per subService
                $appointmentCount = rand(2, 5);

                for ($i = 0; $i < $appointmentCount; $i++) {
                    $queueNumber = $queuePrefix . str_pad($queueCounter++, 3, '0', STR_PAD_LEFT);
                    
                    $name = $firstNames[array_rand($firstNames)] . ' ' . 
                           $lastNames[array_rand($lastNames)];

                    Appointment::create([
                        'main_service' => $serviceGroup['service'],
                        'sub_service' => $subService,
                        'appointment_date' => Carbon::createFromTimestamp(
                            rand($startDate->timestamp, $endDate->timestamp)
                        )->format('Y-m-d'),
                        'appointment_time' => $times[array_rand($times)],
                        'customer_name' => $name,
                        'customer_nik' => mt_rand(1000000000000000, 9999999999999999),
                        'customer_phone' => '08' . mt_rand(10000000, 99999999),
                        'whatsapp' => '08' . mt_rand(10000000, 99999999),
                        'queue_number' => $queueNumber,
                        'queue_prefix' => $queuePrefix,
                        'status' => $statuses[array_rand($statuses)]
                    ]);
                }
            }
        }
    }
}