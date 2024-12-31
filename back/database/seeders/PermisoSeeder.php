<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('permisos')->insert([
            ["nombre"=>"GESTION USUARIOS"],
            ["nombre"=>"VER INSPECCION"],
            ["nombre"=>"REGISTRAR"],
            ["nombre"=>"MOD DATOS"],
            ["nombre"=>"MOD TUBERIAS"],
        ]);

        DB::table('permiso_user')->insert([
            ['permiso_id'=>1,'user_id'=>1],
            ['permiso_id'=>2,'user_id'=>1],
            ['permiso_id'=>3,'user_id'=>1],
            ['permiso_id'=>4,'user_id'=>1],
            ['permiso_id'=>5,'user_id'=>1],
        ]);

    }
}
