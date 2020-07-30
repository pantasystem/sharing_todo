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
        DB::table('comments')->insert([
            'title' => 'Topic' . $name,
            'description' => 'Topic' . $name . "TopicEnd",
            'author_id' => 1,
            'group_id' => 1
        ]);
    }
}
