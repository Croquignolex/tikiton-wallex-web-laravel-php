<?php

use App\Models\Team;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Team::create([
            'name' => 'Alex NGOMBOL',
            'en_function' => 'Webmaster',
            'fr_function' => 'Webmaster',
            'image' => 'alex'
        ]);

        Team::create([
            'name' => 'Cathérine Mango',
            'en_function' => 'Contributrice',
            'fr_function' => 'Contributor',
            'image' => 'catherine'
        ]);

        Team::create([
            'name' => 'Célestin WOKGOUE',
            'en_function' => 'Contributeur',
            'fr_function' => 'Contributor',
            'image' => 'celestin'
        ]);

        Team::create([
            'name' => 'Gladys NENGSU',
            'en_function' => 'Designer',
            'fr_function' => 'Designer',
            'image' => 'gladys'
        ]);
    }
}
