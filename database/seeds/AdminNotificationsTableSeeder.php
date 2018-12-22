<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\AdminNotification;

class AdminNotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [AdminNotification::NEW, AdminNotification::CONFIRMED];
        $users = User::all()->filter(function (User $user) {
            if($user->role->type === Role::USER) return true;
            return false;
        });
        foreach ($users as $user)
        {
            for($i = 1; $i <= 3; $i++)
            {
                $user->admin_notifications()->create([
                    'type' => $types[rand(0, 1)]
                ]);
            }
        }
    }
}
