<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([
            'name' => 'Absensi RFID',
            'mode' => 'pengguna',
            'slug' => Str::slug('Absensi RFID'),
            // 'password' => Hash::make('password'),
        ]);
    }
}
