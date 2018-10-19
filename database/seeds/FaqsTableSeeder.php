<?php

use App\Models\Faq;
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
            'fr_question' => 'A combien coûte l\'accès à WALLEX?',
            'en_question' => 'What is teh cost of WALLEX access',
            'fr_answer' => 'WALLEX est totalement gratuit et le sera toujour.' .
                ' Par contre les publicité et autre contenue supplémentaires sont payants.' .
                ' Veillez vous rapprocher de la direction pour plus de détails',
            'en_answer' => 'WALLEX is totaly free an it will always be free.' .
                ' But advising and other supply content are not free.' .
                ' Get close to the direction for more details.',
        ]);
    }
}
