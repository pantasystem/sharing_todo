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
        $name = 'TestTodo';
        DB::table('todos')->insert([
            'title' => 'Todo' . $name,
            'description' => 'Topic' . $name . "TopicEnd",
            'author_id' => 1,
            'group_id' => 1
        ]);
    }
}
