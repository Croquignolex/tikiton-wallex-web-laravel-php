<?php

use App\Models\Wallet;
use App\Models\Currency;
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
        $currencies = Currency::all();
        $i = 0;
        foreach($currencies as $currency)
        {
            $i++;
            $currency->wallets()->create([
                'balance' => rand(100000, 999999),
                'threshold' => rand(10000, 99999),
                'is_stated' => $i === 1 ? false : true,
                'description' => ucfirst(Lorem::text()),
                'color' => '#' . str_shuffle('ABCDEF'),
                'name' => ucfirst($this->getUniqueName())
            ]);

            $currency->wallets()->create([
                'balance' => rand(100000, 999999),
                'threshold' => rand(10000, 99999),
                'is_stated' => $i === 1 ? false : true,
                'description' => ucfirst(Lorem::text()),
                'color' => '#' . str_shuffle('ABCDEF'),
                'name' => ucfirst($this->getUniqueName())
            ]);
        }
    }

    /**
     * @return string
     */
    private function getUniqueName()
    {
        $name = Lorem::sentence(3);

        if(Wallet::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
