<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => bcrypt('123456'),
                'created_at' => now(),
                'updated_at' => now(),
                'email_verified_at' => now(),
            ],
        ]);

        DB::table('permissions')->insert([
            [
                'name' => 'review_post',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'update_post',
                'guard_name' => 'sanctum',
            ],
            [
                'name' => 'delete_post',
                'guard_name' => 'sanctum'
            ],
            [
                'name' => 'restore_post',
                'guard_name' => 'sanctum'
            ],
            [
                'name' => 'force_delete_post',
                'guard_name' => 'sanctum'
            ],
        ]);

        DB::table('roles')->insert([
            ['name' => 'admin', 'guard_name' => 'sanctum'],
        ]);

        DB::table('role_user')->insert([
            'role_id' => 1,
            'model_type' => '',
            'user_id' => 1,
        ]);

        DB::table('permission_role')->insert([
            ['permission_id' => 1, 'role_id' => 1],
            ['permission_id' => 2, 'role_id' => 1],
            ['permission_id' => 3, 'role_id' => 1],
            ['permission_id' => 4, 'role_id' => 1],
            ['permission_id' => 5, 'role_id' => 1],
        ]);
    }
}
