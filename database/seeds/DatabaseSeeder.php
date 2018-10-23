<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(FaqsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
    }
}
