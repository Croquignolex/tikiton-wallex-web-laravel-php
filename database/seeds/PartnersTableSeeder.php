<?php

use App\Models\Partner;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Partner::create([
            'name' => 'BREADCEL',
            'image' => 'breadcel',
            'extension' => 'png',
            'link' => "http:\\\breadcel.ca"
        ]);
    }
}
