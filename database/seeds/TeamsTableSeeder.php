<?php

use App\Models\Team;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 9; $i++)
        {
            Team::create([
                'image' => 'default',
                'is_visible' => $i <= 4,
                'name' => title_case(Lorem::sentence(2)),
                'en_function' => ucfirst(Lorem::sentence(3)),
                'fr_function' => ucfirst(Lorem::sentence(3)),
            ]);
        }
    }
}
