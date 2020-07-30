<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text = 'hogehogeHogeeeeee';
        DB::table('comments')->insert([
            'text' => $text,
            'todo_id' => 4,
            'author_id' => 1,
        ]);
    }
}
