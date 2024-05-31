<?php
use Illuminate\Database\Seeder;

class IngredientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = [];
        for($i = 1; $i < 100; $i++)
            array_push($ingredients, array('id' => $i, 'code' => "ingredient$i"));

        DB::table('aes_ingredient')->insert($ingredients);

        DB::table('aes_ingredient_feature')->insert([
            [ 'ingredient_id' => 1, 'feature_id' => 1, ], 
            [ 'ingredient_id' => 1, 'feature_id' => 2, ], 
            [ 'ingredient_id' => 2, 'feature_id' => 1, ],
        ]);

        DB::table('aes_ingredient_country')->insert([
            [ 'ingredient_id' => 1, 'country_id' => 1, ], 
            [ 'ingredient_id' => 1, 'country_id' => 2, ], 
            [ 'ingredient_id' => 1, 'country_id' => 3, ],
            [ 'ingredient_id' => 2, 'country_id' => 1, ],
            [ 'ingredient_id' => 2, 'country_id' => 2, ],
            [ 'ingredient_id' => 2, 'country_id' => 3, ],
            [ 'ingredient_id' => 3, 'country_id' => 1, ],
            [ 'ingredient_id' => 3, 'country_id' => 2, ],
            [ 'ingredient_id' => 3, 'country_id' => 3, ]
        ]);

        
        DB::table('aes_ingredient_lang')->insert($ingredient_lang);
    }
}
