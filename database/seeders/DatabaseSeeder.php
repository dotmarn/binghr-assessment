<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DefaultRoleSeeder::class);
        $this->call(DefaultPermissionSeeder::class);
        $this->call(AttachPermissionToSuperAdmin::class);
        $this->call(AttachPermissionToAdmin::class);
        $this->call(AttachPermissionToEmployee::class);
        $this->call(AttachPermissionToHrAdmin::class);
    }
}
