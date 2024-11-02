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
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'Horror',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]];

        DB::table('genres')->insertOrIgnore($genres);
    }
}
