<?php

use App\Models\Category;
use Faker\Provider\Lorem;
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
            for($i = 0; $i <= 12; $i++)
            {
                for($j = 0; $j <= 7; $j++)
                {
                    $category->transactions()->create([
                        'description' => ucfirst(Lorem::text()),
                        'amount' => rand(100000, 999999),
                        'currency_id' => $category->user->currencies->random()->id,
                        'created_at' => now()->startOfWeek()
                            ->addMonth($i)->addDay($j)
                            ->addSecond(rand(0, 1000))
                    ]);
                }
            }
        }
    }
}
