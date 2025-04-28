<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'Ahmet Yılmaz',
                'email' => 'ahmet.yilmaz@example.com',
                'specialty' => 'Diş Hekimliği',
                'city' => 'İstanbul',
                'is_featured' => true,
            ],
            [
                'name' => 'Ayşe Demir',
                'email' => 'ayse.demir@example.com',
                'specialty' => 'Diş Hekimliği',
                'city' => 'Ankara',
                'is_featured' => true,
            ],
            [
                'name' => 'Mehmet Kaya',
                'email' => 'mehmet.kaya@example.com',
                'specialty' => 'Diş Hekimliği',
                'city' => 'İzmir',
                'is_featured' => true,
            ],
            [
                'name' => 'Zeynep Şahin',
                'email' => 'zeynep.sahin@example.com',
                'specialty' => 'Diş Hekimliği',
                'city' => 'Bursa',
                'is_featured' => true,
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::create($doctor);
        }
    }
} 