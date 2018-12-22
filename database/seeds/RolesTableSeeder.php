<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['type' => Role::USER]);
        Role::create(['type' => Role::ADMIN]);
        Role::create(['type' => Role::SUPER_ADMIN]);
    }
}
