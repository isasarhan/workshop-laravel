<?php

use Illuminate\Database\Seeder;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'level_name'=>'admin',
        ]);
        DB::table('levels')->insert([
            'level_name'=>'monitor',
        ]);
        DB::table('levels')->insert([
            'level_name'=>'participant',
        ]);
    }
}
