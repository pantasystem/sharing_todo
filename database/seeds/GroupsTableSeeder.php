<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names = ['A', 'B', 'C'];
        foreach( $names as $name ){
            DB::table('groups')->insert([
                'name' => $name . 'Group'
            ]);
        }

        DB::table('members')->insert([
            'group_id' => 1,
            'user_id' => 1,
            'is_admin' => false
        ]);
    }
}
