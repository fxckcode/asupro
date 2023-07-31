<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnidadMedidaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $unidad_medida = [
            ['id' => 1, 'nombre' => 'kg'],
            ['id' => 2, 'nombre' => 'lb'],
            ['id' => 3, 'nombre' => 'arroba'],
        ];

        DB::table('unidad_medida')->insert($unidad_medida);
    }
}
