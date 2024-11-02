<?php

namespace Database\Seeders;

use App\Enums\RoleEnums;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoleId = Role::where('id', '=', RoleEnums::ADMIN->value)->first()->id;
        $userRoleId = Role::where('id', '=', RoleEnums::USER->value)->first()->id;

        $users = [
            [
                'username' => 'superadmin',
                'role_id' => $adminRoleId,
                'password' => Hash::make('superadmin'),
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'username' => 'simple',
                'role_id' => $userRoleId,
                'password' => Hash::make('simple'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        DB::table('users')->insertOrIgnore($users);
    }
}
