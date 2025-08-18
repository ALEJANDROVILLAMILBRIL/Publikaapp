<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['code' => 'AMA', 'name' => 'Amazonas'],
            ['code' => 'ANT', 'name' => 'Antioquia'],
            ['code' => 'ARA', 'name' => 'Arauca'],
            ['code' => 'ATL', 'name' => 'Atlántico'],
            ['code' => 'BOL', 'name' => 'Bolívar'],
            ['code' => 'BOY', 'name' => 'Boyacá'],
            ['code' => 'CAL', 'name' => 'Caldas'],
            ['code' => 'CAQ', 'name' => 'Caquetá'],
            ['code' => 'CAS', 'name' => 'Casanare'],
            ['code' => 'CAU', 'name' => 'Cauca'],
            ['code' => 'CES', 'name' => 'Cesar'],
            ['code' => 'CHO', 'name' => 'Chocó'],
            ['code' => 'COR', 'name' => 'Córdoba'],
            ['code' => 'CUN', 'name' => 'Cundinamarca'],
            ['code' => 'GUA', 'name' => 'Guainía'],
            ['code' => 'GVR', 'name' => 'Guaviare'],
            ['code' => 'HUI', 'name' => 'Huila'],
            ['code' => 'LAG', 'name' => 'La Guajira'],
            ['code' => 'MAG', 'name' => 'Magdalena'],
            ['code' => 'MET', 'name' => 'Meta'],
            ['code' => 'NAR', 'name' => 'Nariño'],
            ['code' => 'NSA', 'name' => 'Norte de Santander'],
            ['code' => 'PUT', 'name' => 'Putumayo'],
            ['code' => 'QUI', 'name' => 'Quindío'],
            ['code' => 'RIS', 'name' => 'Risaralda'],
            ['code' => 'SAP', 'name' => 'San Andrés y Providencia'],
            ['code' => 'SAN', 'name' => 'Santander'],
            ['code' => 'SUC', 'name' => 'Sucre'],
            ['code' => 'TOL', 'name' => 'Tolima'],
            ['code' => 'VAC', 'name' => 'Valle del Cauca'],
            ['code' => 'VAU', 'name' => 'Vaupés'],
            ['code' => 'VID', 'name' => 'Vichada'],
        ];

        foreach ($departments as $dept) {
            Region::create([
                'code' => $dept['code'],
                'slug' => Str::slug($dept['name']),
                'name' => $dept['name'],
            ]);
        }
    }
}
