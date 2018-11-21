<?php

use App\Models\User;
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
        $types = [Category::EXPENSE, Category::TRANSFER, Category::INCOME];
        $users = User::where('is_admin', false)->where('is_super_admin', false)->get();
        foreach ($users as $user)
        {
            $max = rand(2, 9);
            for($i = 1; $i <= $max; $i++)
            {
                $user->categories()->create([
                    'description' => ucfirst(Lorem::text()),
                    'color' => '#' . str_shuffle('ABCDEF'),
                    'name' => ucfirst($this->getUniqueName()),
                    'icon' => icons()->random(),
                    'type' => $types[rand(0, 2)]
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
