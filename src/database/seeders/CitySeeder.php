<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $response = Http::get('https://raw.githubusercontent.com/marcovega/colombia-json/master/colombia.json');
        $departamentos = $response->json();

        foreach ($departamentos as $departamento) {
            // Crear o tomar la región
            $region = Region::firstOrCreate(
                ['name' => $departamento['departamento']],
                [
                    'code' => strtoupper(Str::substr(Str::slug($departamento['departamento']), 0, 3)),
                    'slug' => Str::slug($departamento['departamento']),
                ]
            );

            // Crear ciudades asegurando unicidad por region
            foreach ($departamento['ciudades'] as $ciudad) {
                City::firstOrCreate(
                    [
                        'slug' => Str::slug($ciudad . '-' . $region->slug),
                        'region_id' => $region->id
                    ],
                    [
                        'name' => $ciudad
                    ]
                );
            }
        }
    }
}
