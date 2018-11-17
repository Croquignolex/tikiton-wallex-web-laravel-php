<?php

use App\Models\Currency;
use App\Models\User;
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
        $users = User::where('is_admin', false)->where('is_super_admin', false)->get();
        foreach ($users as $user)
        {
            $max = rand(2, 9);
            for($i = 1; $i <= $max; $i++)
            {
                $user->currencies()->create([
                    'name' => strtoupper($this->getUniqueName()),
                    'description' => ucfirst(Lorem::text()),
                    'devaluation' => rand(100, 9999),
                    'symbol' => $this->getUniqueSymbol()
                ]);
            }
        }
    }

    /**
     * @return string
     */
    private function getUniqueName()
    {
        $name = Lorem::sentence(2);

        if(Currency::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }

    /**
     * @return string
     */
    private function getUniqueSymbol()
    {
        $symbol = str_shuffle('ABCDEF');

        if(Currency::where(['symbol' => $symbol])->count() > 0)
            return $this->getUniqueSymbol();

        return $symbol;
    }
}
