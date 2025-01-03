<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(FaqsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeamsTableSeeder::class);
        $this->call(PartnersTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(TestimonialsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(UserSettingsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(TransactionsTableSeeder::class);
        $this->call(TransactionWalletsTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(AdminNotificationsTableSeeder::class);
    }
}
