<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [Notification::EMPTY, Notification::NEW, Notification::PASSED, Notification::REACHED];
        $users = User::all()->filter(function (User $user) {
            if($user->role->type === Role::USER) return true;
            return false;
        });
        foreach ($users as $user)
        {
            for($i = 1; $i <= 3; $i++)
            {
                $user->notifications()->create([
                    'type' => $types[rand(0, 3)],
                    'wallet_id' => $user->wallets->random()->id
                ]);
            }
        }
    }
}
