<?php

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('prstshp_lang')->insert([
            [
                'id' => 1,
                'name' => 'English',
                'active' => 1
            ],
            [
                'id' => 2,
                'name' => 'German',
                'active' => 1
            ],
            [
                'id' => 3,
                'name' => 'French',
                'active' => 1
            ]
        ]);
    }
}
