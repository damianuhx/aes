<?php
use Illuminate\Database\Seeder;

class FeatureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aes_feature')->insert([
            [
                'id' => 1,
                'rule' => 'all',
                'tag_id' => '1'
            ], 
            [
                'id' => 2,
                'rule' => 'all',
                'tag_id' => '2'
            ], 
            [
                'id' => 3,
                'rule' => 'all',
                'tag_id' => '2'
            ], 
        ]);

        DB::table('aes_feature_lang')->insert([
            [
                'feature_id' => 1,
                'language_id' => 1,
                'name' => 'Meat '
            ], 
            [
                'feature_id' => 1,
                'language_id' => 2,
                'name' => 'Meat (German)'
            ], 
            [
                'feature_id' => 1,
                'language_id' => 3,
                'name' => 'Meat (French)'
            ],
            [
                'feature_id' => 2,
                'language_id' => 1,
                'name' => 'Processed'
            ],
            [
                'feature_id' => 2,
                'language_id' => 2,
                'name' => 'Processed (German)'
            ],
            [
                'feature_id' => 2,
                'language_id' => 3,
                'name' => 'Processed (French)'
            ],
            [
                'feature_id' => 3,
                'language_id' => 1,
                'name' => 'Artificial'
            ],
            [
                'feature_id' => 3,
                'language_id' => 2,
                'name' => 'Artificial (German)'
            ],
            [
                'feature_id' => 3,
                'language_id' => 3,
                'name' => 'Artificial (French)'
            ]
        ]);
    }
}
