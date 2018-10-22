<?php

use App\Models\Contact;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 30; $i++)
        {
            Contact::create([
                'message' => ucfirst(Lorem::text()),
                'subject' => ucfirst(Lorem::sentence()),
                'phone' => str_shuffle('0123456789'),
                'email' => Lorem::word() . '@wallex.com',
                'name' => title_case(Lorem::sentence(2))
            ]);
        }
    }
}
