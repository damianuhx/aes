<?php

use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aes_tag')->insert([
            [
                'id' => 1,
                'tag_id' => null,
            ], 
            [
                'id' => 2,
                'tag_id' => 1
            ], 
            [
                'id' => 3,
                'tag_id' => null
            ]
        ]);

        DB::table('aes_tag_lang')->insert([
            [
                'tag_id' => 1,
                'language_id' => 1,
                'name' => 'Vegetarian',
            ], 
            [
                'tag_id' => 1,
                'language_id' => 2,
                'name' => 'Vegetarisch'
            ], 
            [
                'tag_id' => 1,
                'language_id' => 3,
                'name' => 'Végétarien'
            ],
            [
                'tag_id' => 2,
                'language_id' => 1,
                'name' => 'Vegan'
            ],
            [
                'tag_id' => 2,
                'language_id' => 2,
                'name' => 'Vegan (German)'
            ],
            [
                'tag_id' => 2,
                'language_id' => 3,
                'name' => 'Vegan (French)'
            ],
            [
                'tag_id' => 3,
                'language_id' => 1,
                'name' => 'Cool'
            ],
            [
                'tag_id' => 3,
                'language_id' => 2,
                'name' => 'Cool (German)'
            ],
            [
                'tag_id' => 3,
                'language_id' => 3,
                'name' => 'Cool (French)'
            ]
        ]);
    }
}
