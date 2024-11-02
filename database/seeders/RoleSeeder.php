<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [[
            'name' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'name' => 'user',
            'created_at' => now(),
            'updated_at' => now()
        ]];

        DB::table('roles')->insertOrIgnore($roles);
    }
}
