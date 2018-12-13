<?php

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
        $users = User::where('is_admin', false)->where('is_super_admin', false)->get();
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
