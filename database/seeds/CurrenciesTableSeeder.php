<?php

use App\Models\Role;
use App\Models\User;
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
        $users = User::all()->filter(function (User $user) {
            if($user->role->type === Role::USER) return true;
            return false;
        });
        foreach ($users as $user)
        {
            for($i = 1; $i <= 3; $i++)
            {
                $user->currencies()->create([
                    'name' => strtoupper($this->getUniqueName()),
                    'description' => ucfirst(Lorem::text()),
                    'devaluation' => rand(100, 9999),
                    'symbol' => $this->getUniqueSymbol(),
                    'is_current' => $i === 1
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
