<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DefaultPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            "Read",
            "Write",
            "Delete"
        ];

        foreach ($permissions as $key => $permission) {
            Permission::updateOrCreate([
                'name' => $permission
            ]);
        }
    }
}
