<?php

namespace Database\Seeders;

use App\Models\Permiso;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
            PermisoSeeder::class,
        ]);

        DB::table('diametro1')->insert([
            ["medida"=>4],
            ["medida"=>6],
            ["medida"=>8],
            ["medida"=>10],
            ["medida"=>12],
            ["medida"=>14],
            ["medida"=>16],
            ["medida"=>18],
            ["medida"=>20],
            ["medida"=>22],
            ["medida"=>24],
            ["medida"=>26],
            ["medida"=>28],
            ["medida"=>30],
            ["medida"=>32],
            ["medida"=>34],
            ["medida"=>36],
            ["medida"=>38],
            ["medida"=>40],
        ]);
        DB::table('diametro2')->insert([
            ["medida"=>0.10],
            ["medida"=>0.15],
            ["medida"=>0.20],
            ["medida"=>0.25],
            ["medida"=>0.30],
            ["medida"=>0.35],
            ["medida"=>0.40],
            ["medida"=>0.45],
            ["medida"=>0.50],
            ["medida"=>0.55],
            ["medida"=>0.60],
            ["medida"=>0.65],
            ["medida"=>0.70],
            ["medida"=>0.75],
            ["medida"=>0.80],
            ["medida"=>0.85],
            ["medida"=>0.90],
            ["medida"=>0.95],
            ["medida"=>1.00],
        ]);
    }
}
