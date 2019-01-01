<?php

use Faker\Provider\Lorem;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Testimonial::create([
            'fr_description' => 'Impressionant, bravo WALLEX',
            'en_description' => 'Awesome, well done WALLEX',
            'name' => 'Anonymize',
            'fr_function' => 'Etudiant',
            'en_function' => 'Student',
        ]);

        Testimonial::create([
            'fr_description' => 'C\'est exactement ce que je veux, j\'attend impatiemment la version mobile',
            'en_description' => 'Is is exactly what i want, i am waiting impatiently the mobile version',
            'name' => 'Anonymize',
            'en_function' => 'Webmaster',
            'fr_function' => 'Webmaster',
        ]);

        Testimonial::create([
            'fr_description' => 'Je gerais ma marchandise avec le stylo et le papier, je gagne énormement en temps avec WALLEX',
            'en_description' => 'I was managing my goods with pen and paper, i gained so much time with WALLEX',
            'name' => 'Anonymize',
            'fr_function' => 'Commerçant',
            'en_function' => 'Seller',
        ]);
    }
}
