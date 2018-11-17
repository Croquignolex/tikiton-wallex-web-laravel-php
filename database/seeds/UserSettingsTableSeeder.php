<?php

use App\Models\User;
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
        $users = User::where('is_admin', false)->where('is_super_admin', false)->get();
        foreach ($users as $user)
        {
            $max = rand(2, 9);
            for($i = 1; $i <= $max; $i++)
            {
                $user->user_settings()->create([
                    'tips' => $i == 1,
                    'is_current' => $i == 1,
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
