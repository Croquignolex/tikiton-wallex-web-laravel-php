<?php

use App\Models\Role;
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
        $users = User::all()->filter(function (User $user) {
            if($user->role->type === Role::USER) return true;
            return false;
        });
        foreach ($users as $user)
        {
            for($i = 1; $i <= 2; $i++)
            {
                $user->user_settings()->create([
                    'tips' => $i === 1,
                    'is_current' => $i === 1,
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
