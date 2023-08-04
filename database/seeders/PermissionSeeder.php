<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = config('auth.defaults.guard');

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(
            [
                'name' => 'view',
                'guard_name' => $guardName
            ],
        );
        Permission::create(
            [
                'name' => 'edit',
                'guard_name' => $guardName
            ],
        );
        Permission::create(
            [
                'name' => 'create',
                'guard_name' => $guardName
            ],
        );
        Permission::create(
            [
                'name' => 'delete',
                'guard_name' => $guardName
            ],
        );
        Role::create(['name' => 'super admin', 'guard_name' => $guardName]);
        Role::create(['name' => 'admin', 'guard_name' => $guardName])->givePermissionTo(['view', 'edit', 'create', 'delete']);
        Role::create(['name' => 'writer', 'guard_name' => $guardName])->givePermissionTo('create');
        Role::create(['name' => 'user', 'guard_name' => $guardName])->givePermissionTo('view');
    }
}
