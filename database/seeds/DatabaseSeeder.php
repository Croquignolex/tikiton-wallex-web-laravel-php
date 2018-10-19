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
        $this->call(TestimonialsTableSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
    }
}
