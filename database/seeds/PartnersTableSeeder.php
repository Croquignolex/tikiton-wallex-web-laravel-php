<?php

use App\Models\Partner;
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
            'image' => 'partner_1',
            'name' => 'Partner',
            'extension' => 'png'
        ]);

        Partner::create([
            'image' => 'partner_2',
            'name' => 'Partner',
            'extension' => 'png'
        ]);

        Partner::create([
            'image' => 'partner_3',
            'name' => 'Partner',
            'extension' => 'png'
        ]);

        Partner::create([
            'image' => 'partner_4',
            'name' => 'Partner',
            'extension' => 'png'
        ]);
    }
}
