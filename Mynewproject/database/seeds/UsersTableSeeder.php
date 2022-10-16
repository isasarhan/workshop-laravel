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
        $level = DB::table('levels')->where('level_name', 'admin')->first();
        $status = DB::table('statuses')->where('status_name', 'approved')->first();
        
        DB::table('users')->insert([
            'user_first_name'=>'admin',
            'user_last_name'=>'admin',
            'email'=>'admin@system.com',
            'password'=>bcrypt('admin'),
            'user_level_id'=>$level->id,
            'user_status_id'=>$status->id,
        ]);
    }
}
