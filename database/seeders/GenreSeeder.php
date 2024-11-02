<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [[
            'name' => 'Action',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Horror',
            'created_at' => now(),
            'updated_at' => now(),
        ]];

        DB::table('genres')->insertOrIgnore($genres);
    }
}
