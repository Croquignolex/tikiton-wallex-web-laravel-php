<?php

use App\Models\Partner;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 15; $i++)
        {
            Partner::create([
                'is_visible' => $i <= 4,
                'name' => title_case(Lorem::word())
            ]);
        }
    }
}
