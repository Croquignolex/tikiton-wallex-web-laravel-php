<?php

use App\Models\Faq;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class FaqsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 60; $i++)
        {
            Faq::create([
                'fr_answer' => ucfirst(Lorem::text(300)),
                'en_answer' => ucfirst(Lorem::text(300)),
                'fr_question' => ucfirst(Lorem::sentence()),
                'en_question' => ucfirst(Lorem::sentence()),
            ]);
        }
    }
}
