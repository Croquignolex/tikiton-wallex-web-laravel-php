<?php

use App\Models\Wallet;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class WalletsTableSeeder extends Seeder
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
            for($j = 1; $j <= 13; $j++)
            {
                Wallet::create([
                    'user_id' => $i,
                    'balance' => rand(100000, 999999),
                    'threshold' => rand(10000, 99999),
                    'stated' => $i < 4 ? false : true,
                    'description' => ucfirst(Lorem::text()),
                    'color' => '#' . str_shuffle('ABCDEF'),
                    'name' => ucfirst($this->getUniqueName())
                ]);
            }
        }
    }

    private function getUniqueName()
    {
        $name = Lorem::sentence(3);

        if(Wallet::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
