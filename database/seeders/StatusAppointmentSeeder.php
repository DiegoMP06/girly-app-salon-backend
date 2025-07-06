<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusAppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status_appointments')->insert([
            'status' => 'Pendiente',
        ]);

        DB::table('status_appointments')->insert([
            'status' => 'Aceptada',
        ]);

        DB::table('status_appointments')->insert([
            'status' => 'Rechazada',
        ]);

        DB::table('status_appointments')->insert([
            'status' => 'Cancelada',
        ]);

        DB::table('status_appointments')->insert([
            'status' => 'Completa',
        ]);
    }
}
