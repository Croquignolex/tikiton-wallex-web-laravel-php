<?php

use App\Models\Role;
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
        $types = [Category::EXPENSE, Category::INCOME];
        $users = User::all()->filter(function (User $user) {
                if($user->role->type === Role::USER) return true;
                return false;
            });
        foreach ($users as $user)
        {
            $max = rand(2, 15);
            for($i = 1; $i <= $max; $i++)
            {
                $user->categories()->create([
                    'description' => ucfirst(Lorem::text()),
                    'color' => '#' . str_shuffle('ABCDEF'),
                    'name' => ucfirst($this->getUniqueName()),
                    'icon' => icons()->random(),
                    'type' => $types[rand(0, 1)]
                ]);
            }
            $user->categories()->create([
                'description' => ucfirst(Lorem::text()),
                'color' => '#2196F3',
                'name' => 'transfer',
                'icon' => 'exchange',
                'type' => Category::TRANSFER
            ]);
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
