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
        Faq::create([
            'fr_answer' => 'Tout le monde sans exception',
            'en_answer' => 'Everyone without exception',
            'fr_question' => 'Qui peut utiliser WALLEX?',
            'en_question' => 'Who can use WALLEX?',
        ]);
    }
}
