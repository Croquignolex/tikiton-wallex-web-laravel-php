<?php

use App\Models\Category;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
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
            for($j = 1; $j <= 7; $j++)
            {
                Category::create([
                    'user_id' => $i,
                    'description' => ucfirst(Lorem::text()),
                    'color' => '#' . str_shuffle('ABCDEF'),
                    'name' => ucfirst($this->getUniqueName()),
                    'icon' => icons()->random(),
                    'type' => rand(0, 2)
                ]);
            }
        }
    }

    /**
     * @return string
     */
    private function getUniqueName()
    {
        $name = Lorem::sentence(3);

        if(Category::where(['name' => strtoupper($name)])->count() > 0)
            return $this->getUniqueName();

        return $name;
    }
}
