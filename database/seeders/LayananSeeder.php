<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('layanans')->insert([
            [
                'name' => 'Cuci Reguler (3-4 Hari)',
                'category' => 'Reguler',
                'price' => 7000,
                'description' => 'Layanan cuci reguler Rp 7.000/kg (estimasi 3-4 hari).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cuci Ekspress (1-2 Hari)',
                'category' => 'Ekspress',
                'price' => 12000,
                'description' => 'Layanan cuci ekspress Rp 12.000/kg (estimasi 1-2 hari).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cuci Superkilat (5 Jam)',
                'category' => 'Superkilat',
                'price' => 25000,
                'description' => 'Layanan cuci superkilat Rp 25.000/kg (5 jam selesai).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}