<?php

use App\Models\Currency;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
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
            for($j = 1; $j <= 32; $j++)
            {
                Currency::create([
                    'user_id' => $i,
                    'name' => strtoupper($this->getUniqueName()),
                    'description' => ucfirst(Lorem::text()),
                    'devaluation' => rand(100, 9999),
                    'is_current' => $j == 1,
                    'symbol' => $i == 1 ? 'XAF' : str_shuffle('ABCDEF')
                ]);
            }
        }
    }

    private function getUniqueName()
    {
        $name = Lorem::sentence(2);

        if(Currency::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
