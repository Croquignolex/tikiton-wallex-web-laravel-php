<?php

use App\Models\Team;
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
            'image' => 'team_1',
            'name' => 'Alex NGOMBOL',
            'en_function' => 'General Manager',
            'fr_function' => 'Directeur Général'
        ]);

        Team::create([
            'image' => 'team_2',
            'name' => 'Gladys NENGSU',
            'fr_function' => 'Directeur des Réssources Humaines',
            'en_function' => 'Human Resources Manager'
        ]);

        Team::create([
            'image' => 'team_3',
            'name' => 'Cathérine MANGO',
            'fr_function' => 'Responsable Formation',
            'en_function' => 'Training Officer'
        ]);

        Team::create([
            'image' => 'team_4',
            'name' => 'Celestin WOKGOUE',
            'fr_function' => 'Responsable Relations Externes',
            'en_function' => 'External Relationships Officer'
        ]);
    }
}
