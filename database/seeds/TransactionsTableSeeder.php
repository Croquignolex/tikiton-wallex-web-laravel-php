<?php

use App\Models\Category;
use Faker\Provider\Lorem;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();
        foreach($categories as $category)
        {
            $category->transactions()->create([
                'name' => ucfirst($this->getUniqueName()),
                'description' => ucfirst(Lorem::text()),
                'amount' => rand(100000, 999999)
            ]);

            $category->transactions()->create([
                'name' => ucfirst($this->getUniqueName()),
                'description' => ucfirst(Lorem::text()),
                'amount' => rand(100000, 999999)
            ]);
        }
    }

    /**
     * @return string
     */
    private function getUniqueName()
    {
        $name = Lorem::sentence(3);

        if(Transaction::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
