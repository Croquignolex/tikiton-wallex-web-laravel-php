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
        for($i = 1; $i <= 9; $i++)
        {
            Testimonial::create([
                'image' => 'default',
                'is_visible' => $i <= 3,
                'fr_description' => ucfirst(Lorem::sentence()),
                'en_description' => ucfirst(Lorem::sentence()),
                'name' => title_case(Lorem::sentence(2)),
                'en_function' => ucfirst(Lorem::sentence(3)),
                'fr_function' => ucfirst(Lorem::sentence(3)),
            ]);
        }
    }
}
