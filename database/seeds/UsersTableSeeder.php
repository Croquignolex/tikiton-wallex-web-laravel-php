<?php

use App\Models\User;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_max = rand(5, 9);

        for($i = 1; $i <= $user_max; $i++)
        {
            $first_name = title_case(Lorem::word());
            $last_name = title_case(Lorem::word());

            User::create([
                'is_admin' => $i <= 4,
                'password' => 'aaaaaa',
                'is_confirmed' => true,
                'is_super_admin' => $i == 1,
                'token' => str_random(64),
                'city' => title_case(Lorem::word()),
                'country' => title_case(Lorem::word()),
                'phone' => str_shuffle('0123456789'),
                'last_name' =>  $last_name,
                'post_code' => title_case(Lorem::word()),
                'first_name' => $first_name,
                'description' => ucfirst(Lorem::paragraph()),
                'address' => title_case(Lorem::sentence(2)),
                'profession' => title_case(Lorem::sentence(2)),
                'email' => $i == 1 ? 'alexstephane.ngombol@wallex.com' : $first_name . '.' . $last_name . '@wallex.com'
            ]);
        }
    }
}
