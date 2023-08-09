<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $adminUser = User::where('email', 'admin@admin.com')->first();
        $adminUser->assignRole('admin');

        $bookKeys = [
            'book.index',
            'book.show',
            'book.update',
            'book.destroy',
            'book.store',
        ];

        $bookPermissions = [];

        foreach ($bookKeys as $key) {
            $permission = Permission::create(['name' => $key]);
            $bookPermissions[] = $permission;
        }

        $adminRole->syncPermissions($bookPermissions);
    }
}
