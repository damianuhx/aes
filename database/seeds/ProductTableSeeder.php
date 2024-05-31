<?php
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];
        for ($i = 1; $i < 100; $i++) {
            array_push($products, array(
                'id' => $i,
                'reference' => 'Reference',
                'weight' => rand(1,9) * 100,
                'content' => rand(1,9) * 100,
                'measure_id' => rand(1,3),
                'content_netto' => rand(1,9) * 100,
                'measure_netto_id' => rand(1,3),
                'nutrient_netto' => rand(1,9) * 100,
                'nutrient_netto_id' => rand(1,3),
            ));
        }
        DB::table('product')->insert($products);

        DB::table('product_ingredient')->insert([
            [
                'product_id' => 1,
                'ingredient_id' => 1,
                'position' => 1,
                'amount' => '2 spoons'
            ], 
            [
                'product_id' => 1,
                'ingredient_id' => 2,
                'position' => 2,
                'amount' => '2 spoons'
            ], 
            [
                'product_id' => 1,
                'ingredient_id' => 3,
                'position' => 3,
                'amount' => '2 spoons'
            ],
        ]);

        $product_lang = [];
        for($i = 1; $i < 100; $i++) {
            for ($j = 1; $j < 4; $j++) {
                if ($j == 1) {
                    $name = "product$i";
                    $text = "This is a major description. It goes first.";
                    $posttext = 'This is minor description. It goes after.';
                }
                elseif ($j == 2) {
                    $name = "product$i (German)";
                    $text = "This is a major description. It goes first. (German)";
                    $posttext = 'This is minor description. It goes after. (German)';
                }
                else {
                    $name = "product$i (French)";
                    $text = "This is a major description. It goes first. (French)";
                    $posttext = 'This is minor description. It goes after. (French)';
                }

                array_push($product_lang, array(
                    'product_id' => $i, 
                    'language_id' => $j, 
                    'name' => $name,
                    'text' => $text,
                    'posttext' => $posttext,
                ));
            }
        }

        DB::table('product_lang')->insert($product_lang);

        DB::table('product_tag')->insert([
            [
                'product_id' => 1,
                'tag_id' => 1,
            ], 
            [
                'product_id' => 1,
                'tag_id' => 2,
            ], 
            [
                'product_id' => 1,
                'tag_id' => 3,
            ]
        ]);

        DB::table('nutrient_product')->insert([
            [
                'product_id' => 1,
                'nutrient_id' => 1,
                'amount' => 20
            ], 
            [
                'product_id' => 1,
                'nutrient_id' => 2,
                'amount' => 30
            ], 
            [
                'product_id' => 1,
                'nutrient_id' => 3,
                'amount' => 100
            ]
        ]);
    }
}
