<?php

use Illuminate\Database\Seeder;
use App\Group;
use App\User;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // group 従属Category
        // user　従属Category

        Group::find(1)->categoriesUsed()
            ->create([
                'name' => 'Group1sCategory'
            ]);

        $category = User::find(1)->categoriesUsed()
            ->create([
                'name' => 'User1sCategory'
            ]);

       
    }
}
