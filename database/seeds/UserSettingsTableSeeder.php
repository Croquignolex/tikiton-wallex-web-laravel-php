<?php

use Faker\Provider\Lorem;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;

class UserSettingsTableSeeder extends Seeder
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
            for($j = 1; $j <= 9; $j++)
            {
                UserSetting::create([
                    'user_id' => $i,
                    'is_current' => $j == 1,
                    'tips' => $j == 1,
                    'name' => strtoupper($this->getUniqueName()),
                    'description' => ucfirst(Lorem::text())
                ]);
            }
        }
    }

    private function getUniqueName()
    {
        $name = Lorem::sentence(2);

        if(UserSetting::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
