<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Muhamad Iqbal Rivaldi',
            'rfid' => 123456789,
            'email' => 'muhamadiqbalrivaldi@gmail.com',
            // 'password' => Hash::make('password'),
        ]);
    }
}
