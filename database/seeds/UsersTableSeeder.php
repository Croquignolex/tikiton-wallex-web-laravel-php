<?php

use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
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
            $user = new User();
            $user->is_admin = $i <= 4;
            $user->is_confirmed = true;
            $user->is_super_admin = $i == 1;
            $user->token = str_random(64);
            $user->city = title_case(Lorem::word());
            $user->country = title_case(Lorem::word());
            $user->phone = str_shuffle('0123456789');
            $user->password = Hash::make('wallex');
            $user->last_name = title_case(Lorem::word());
            $user->post_code = title_case(Lorem::word());
            $user->first_name = title_case(Lorem::word());
            $user->description = ucfirst(Lorem::paragraph());
            $user->address = title_case(Lorem::sentence(2));
            $user->profession = title_case(Lorem::sentence(2));
            $user->email = $i == 1 ? 'alexstephane.ngombol@wallex.com' : Lorem::word() . '.' . Lorem::word() . '@wallex.com';
            $user->save();
        }
    }
}
