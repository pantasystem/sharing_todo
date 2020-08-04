<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //　個人関連
         $names = ['A', 'B', 'C'];
         foreach( $names as $name ){
             DB::table('todos')->insert([
                 'title' => 'Todo' . $name,
                 'description' => 'Topic' . $name . "TodoEnd",
                 'author_id' => 1,
                 'user_id' => 1
             ]);
         }
 
         $name = 'GroupTodo';
         DB::table('todos')->insert([
             'title' => 'Topic' . $name,
             'description' => 'Todo' . $name . "TodoEnd",
             'author_id' => 1,
             'group_id' => 1
         ]);
    }
}
