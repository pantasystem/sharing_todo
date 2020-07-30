<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
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
            DB::table('users')->insert([
                'name' => $name,
                'email' => $name . "@test.jp",
                'password' => Hash::make("password")
            ]);
        }
        
    }
}
