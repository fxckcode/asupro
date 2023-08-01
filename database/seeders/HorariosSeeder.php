<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $horario = [
            [
                'id' => 1,
                'dia_inicio' => 1,
                'dia_fin' => 7,
                'hora_inicio' => '07:00:00',
                'hora_fin' => '21:00:00',
                'estado' => 1
            ]
        ];

        DB::table('horarios')->insert($horario);
    }
}
