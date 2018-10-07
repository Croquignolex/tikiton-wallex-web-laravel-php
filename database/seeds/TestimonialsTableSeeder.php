<?php

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
            'image' => 'testimonial_1',
            'name' => 'Alex NGOMBOL',
            'en_function' => 'Junior Developer',
            'fr_function' => 'Développeur Junior',
            'fr_description' => 'Très fier de cette réalisation qui m\'aide au quotidient',
            'en_description' => 'Pround of this realisation that helps me daily'
        ]);

        Testimonial::create([
            'image' => 'testimonial_2',
            'name' => 'Trina WOKGOUE',
            'en_function' => 'Junior Developer',
            'fr_function' => 'Développeur Junior',
            'fr_description' => 'Très impréssionné par le nombre de possibilités réunis au même endroit, merci WALLEX',
            'en_description' => 'Impress by the number of possibilities join in the same place, thank\'s WALLEX'
        ]);

        Testimonial::create([
            'image' => 'default',
            'name' => 'ANONYMIZE',
            'fr_function' => 'INCONNU',
            'en_function' => 'UNKNOWN',
            'fr_description' => 'Témognage',
            'en_description' => 'Testimonial'
        ]);
    }
}
