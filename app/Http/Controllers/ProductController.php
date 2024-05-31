<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;
use App\Ingredient;
use App\Manufacturer;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with(['info' => function($query)
        {
            $query->select('ps_product_lang.name');

        }, 'manufacturer', 'ingredients.info', 'nutrients.info', 'tags.info'
        ])->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::with(['info' => function($query) {
            $query->select(['ps_product_lang.id_lang as language_id','ps_product_lang.name', 'ps_product_lang.text', 'ps_product_lang.posttext']);
        }, 'manufacturer', 'ingredients.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }, 'nutrients.info' => function($query) {
            $query->select(['aes_nutrient_lang.language_id', 'aes_nutrient_lang.name']);
        }, 'tags.info' => function($query) {
            $query->select(['aes_tag_lang.language_id', 'aes_tag_lang.name']);
        }
        ])->with(['ingredients.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->find($id, ['ps_product.id_product as id', 'ps_product.*']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $request->input('data');
            $language_id = $data['language_id'];
            $country_id = $data['country_id'];
            $measure_id = $data['measure_id'];
            $measure_netto_id = $data['measure_netto_id'];
            $weight = $data['weight'];
            $content = $data['content'];
            $content_netto = $data['content_netto'];
            $nutrient_netto = $data['nutrient_netto'];
            $nutrient_netto_id = $data['nutrient_netto_id'];
            $manufacturer_name = $data['manu_name'];
            $ingredients = $data['ingredients'];
            $tags = $data['tags'];
            $nutrients = $data['nutrients'];
            
            $texts = $data['texts'];
            $posttexts = $data['posttexts'];


            $product = Product::find($id);


            $product->country_id = $country_id == 0 ? NULL : $country_id;
            $product->weight = $weight;
            $product->content = $content;
            $product->content_netto = $content_netto;
            $product->measure_id = $measure_id == 0 ? NULL : $measure_id;
            $product->nutrient_netto = $nutrient_netto;
            $product->nutrient_netto_id = $nutrient_netto_id == 0 ? NULL : $nutrient_netto_id;
            $product->measure_netto_id = $measure_id;$measure_netto_id == 0 ? NULL : $measure_netto_id;


            // manufacturer
            $manufacturer = NULL;
            
            if ($manufacturer_name != NULL && $manufacturer_name != '') {
                $manufacturer = Manufacturer::where('name', $manufacturer_name)->first();
                
                if ($manufacturer == NULL) {
                    $manufacturer = new Manufacturer();
                    $manufacturer->name = $manufacturer_name;
                    $manufacturer->save();
                }
                
                $product->manufacturer()->associate($manufacturer);
            }

            // update texts
            foreach($texts as $text) {
                if ($product->info()->get(['ps_product_lang.id_lang'])->contains('id_lang', $text['language']['id']))
                    $product->info()->updateExistingPivot($text['language']['id'], array('text' => $text['value']));
                else
                    $product->info()->attach($text['language']['id'], array('text' => $text['value'], 'link_rewrite' => ''));
            }

            // update posttexts
            foreach($posttexts as $posttext) {
                if ($product->info()->get(['ps_product_lang.id_lang'])->contains('id_lang', $posttext['language']['id']))
                    $product->info()->updateExistingPivot($posttext['language']['id'], array('posttext' => $posttext['value']));
                else
                    $product->info()->attach($posttext['language']['id'], array('posttext' => $posttext['value'], 'link_rewrite' => ''));
            }
            


            // ingredients
            // detach all
            foreach($product->ingredients as $ingredient) {
                foreach($ingredient->children as $subingredient) {
                    foreach($subingredient->children as $sub2ingredient) {
                        foreach($sub2ingredient->children as $sub3ingredient) {
                            $sub3ingredient->children()->detach();
                        }
                        $sub2ingredient->children()->detach();
                    }
                    $subingredient->children()->detach();
                }
                $ingredient->children()->detach();
            }
            $product->ingredients()->detach();

            // attach all
            foreach($ingredients as $ingredient) {
                $dbIngredient = Ingredient::find($ingredient['id']);
                foreach ($ingredient['children'] as $subingredient) {
                    $dbSubIngredient = Ingredient::find($subingredient['id']);
                    foreach ($subingredient['children'] as $sub2ingredient) {
                        $dbSub2Ingredient = Ingredient::find($sub2ingredient['id']);
                        foreach ($sub2ingredient['children'] as $sub3ingredient) {
                            $dbSub3Ingredient = Ingredient::find($sub3ingredient['id']);
                            foreach ($sub3ingredient['children'] as $sub4ingredient) {
                                $dbSub3Ingredient->children()->attach($sub4ingredient['id'],
                                ['amount' => $sub4ingredient['amount'], 'position' => $sub4ingredient['position'], 'country_id' => $sub4ingredient['country_id']]);
                            }
                            $dbSub2Ingredient->children()->attach($sub3ingredient['id'],
                            ['amount' => $sub3ingredient['amount'], 'position' => $sub3ingredient['position'], 'country_id' => $sub3ingredient['country_id']]);
                        }
                        $dbSubIngredient->children()->attach($sub2ingredient['id'],
                        ['amount' => $sub2ingredient['amount'], 'position' => $sub2ingredient['position'], 'country_id' => $sub2ingredient['country_id']]);
                    }
                    $dbIngredient->children()->attach($subingredient['id'],
                    ['amount' => $subingredient['amount'], 'position' => $subingredient['position'], 'country_id' => $subingredient['country_id']]);
                }
                $product->ingredients()->attach($ingredient['id'], 
                ['amount' => $ingredient['amount'], 'position' => $ingredient['position'], 'country_id' => $ingredient['country_id']]);
            }

            // nutrients
            $product->nutrients()->detach();
            foreach($nutrients as $nutrient) {
                if ($nutrient['id'] != 0) {
                    $product->nutrients()->attach($nutrient['id'], ['amount' => $nutrient['value']]);
                }
            }
            
            // tags
            $product->tags()->detach();
            foreach($tags as $tag) {
                if ($tag['id'] != 0)
                $product->tags()->attach($tag['id']);
            }

            $product->touch();
            $product->save();
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
