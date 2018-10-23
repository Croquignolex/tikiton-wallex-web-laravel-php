<?php

use App\Models\Setting;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
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
            Setting::create([
                'is_activated' => $i == 1,
                'tva' => $i > 1 ? 19.25 : rand(1, 100),
                'label' => $i == 1 ? 'Default' : ucfirst(Lorem::sentence(3)),
                'description' => $i == 1 ? 'Default configuration' : ucfirst(Lorem::text())
            ]);
        }
    }
}
