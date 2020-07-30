<?php

use Illuminate\Database\Seeder;

class TopicsTableSeeder extends Seeder
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
            DB::table('topics')->insert([
                'title' => 'Topic' . $name,
                'description' => 'Topic' . $name . "TopicEnd",
                'author_id' => 1
            ]);
        }

        $name = 'GroupTopic';
        DB::table('topics')->insert([
            'title' => 'Topic' . $name,
            'description' => 'Topic' . $name . "TopicEnd",
            'author_id' => 1,
            'group_id' => 1
        ]);

    }
}
