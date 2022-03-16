<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create superadmin role
        $role = Role::create(['name' => 'Super Admin']);

        //create admin role
        $role = Role::create(['name' => 'Admin']);

        //create user role
        $role = Role::create(['name' => 'User']);

        //create superadmin user
        $user = new User;
        $user->username = "superadmin";
        $user->name = "superadmin";
        $user->password = bcrypt("superadmin");
        $user->assignRole(['Super Admin']);
        $user->save();
    }
}
