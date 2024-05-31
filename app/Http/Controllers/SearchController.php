<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;
use App\Language;
use App\Product;
use App\Ingredient;
use App\Nutrient;
use App\Tag;
use App\Feature;
use App\Country;
use App\Measure;
use App\Manufacturer;
use App\SearchResult;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = null;
        $language = null;
        $type = null;

        if ($request->has('q'))
            $query = $request->input('q');

        if ($request->has('lang'))
            $language = $request->input('lang');
        else
            $language = Language::firstOrFail()->id;

        if ($request->has('type'))
            $type = $request->input('type');

        if ($query == null ) {
        $productQuery = DB::table('ps_product')
                    ->join('ps_product_lang', 'ps_product.id_product', '=', 'ps_product_lang.id_product')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'ps_product_lang.id_lang')
                    ->where('ps_product_lang.id_lang', '=', $language)
                    ->select(DB::raw('ps_product.id_product as id') , 'ps_product_lang.name', DB::raw("0 as type"))
                    ->latest('ps_product.updated_at')
                    ->take(10);
        } else {
        $productQuery = DB::table('ps_product')
                    ->join('ps_product_lang', 'ps_product.id_product', '=', 'ps_product_lang.id_product')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'ps_product_lang.id_lang')
                    ->where('ps_product_lang.id_lang', '=', $language)
                    ->where('ps_product_lang.name', 'like', '%'.$query.'%')
                    ->latest('ps_product.updated_at')
                    ->select(DB::raw('ps_product.id_product as id'), 'ps_product_lang.name', DB::raw("0 as type"));
        }
        
        if ($query == null ) {
        $ingredientQuery = DB::table('aes_ingredient')
                    ->join('aes_ingredient_lang', 'aes_ingredient.id', '=', 'aes_ingredient_lang.ingredient_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_ingredient_lang.language_id')
                    ->where([['aes_ingredient_lang.language_id', '=', $language], ['aes_ingredient.parent', '=', 0]])
                    ->select('aes_ingredient.id', 'aes_ingredient_lang.name', DB::raw("1 as type"))
                    ->latest('aes_ingredient.updated_at')
                    ->take(10);
        } else {
        $ingredientQuery = DB::table('aes_ingredient')
                    ->join('aes_ingredient_lang', 'aes_ingredient.id', '=', 'aes_ingredient_lang.ingredient_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_ingredient_lang.language_id')
                    ->where([['aes_ingredient_lang.language_id', '=', $language], ['aes_ingredient.parent', '=', 0]])
                    ->where('aes_ingredient_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_ingredient.id', 'aes_ingredient_lang.name', DB::raw("1 as type"))
                    ->latest('aes_ingredient.updated_at');
        }

        if ($query == null ) {
        $nutrientQuery = DB::table('aes_nutrient')
                    ->join('aes_nutrient_lang', 'aes_nutrient.id', '=', 'aes_nutrient_lang.nutrient_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_nutrient_lang.language_id')
                    ->where('aes_nutrient_lang.language_id', '=', $language)
                    ->select('aes_nutrient.id', 'aes_nutrient_lang.name', DB::raw("2 as type"))
                    ->latest('aes_nutrient.updated_at')
                    ->take(10);
        } else {
        $nutrientQuery = DB::table('aes_nutrient')
                    ->join('aes_nutrient_lang', 'aes_nutrient.id', '=', 'aes_nutrient_lang.nutrient_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_nutrient_lang.language_id')
                    ->where('aes_nutrient_lang.language_id', '=', $language)
                    ->where('aes_nutrient_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_nutrient.id', 'aes_nutrient_lang.name', DB::raw("2 as type"))
                    ->latest('aes_nutrient.updated_at');
        }

        if ($query == null) {
        $tagQuery = DB::table('aes_tag')
                    ->join('aes_tag_lang', 'aes_tag.id', '=', 'aes_tag_lang.tag_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_tag_lang.language_id')
                    ->where('aes_tag_lang.language_id', '=', $language)
                    ->select('aes_tag.id', 'aes_tag_lang.name', DB::raw("3 as type"))
                    ->latest('aes_tag.updated_at')
                    ->take(10);
        } else {
        $tagQuery = DB::table('aes_tag')
                    ->join('aes_tag_lang', 'aes_tag.id', '=', 'aes_tag_lang.tag_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_tag_lang.language_id')
                    ->where('aes_tag_lang.language_id', '=', $language)
                    ->where('aes_tag_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_tag.id', 'aes_tag_lang.name', DB::raw("3 as type"))
                    ->latest('aes_tag.updated_at');
        }
        
        if ($query == null) {
        $featureQuery = DB::table('aes_feature')
                    ->join('aes_feature_lang', 'aes_feature.id', '=', 'aes_feature_lang.feature_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_feature_lang.language_id')
                    ->where('aes_feature_lang.language_id', '=', $language)
                    ->select('aes_feature.id', 'aes_feature_lang.name', DB::raw("4 as type"))
                    ->latest('aes_feature.updated_at')
                    ->take(10);
        } else {
         $featureQuery = DB::table('aes_feature')
                    ->join('aes_feature_lang', 'aes_feature.id', '=', 'aes_feature_lang.feature_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_feature_lang.language_id')
                    ->where('aes_feature_lang.language_id', '=', $language)
                    ->where('aes_feature_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_feature.id', 'aes_feature_lang.name', DB::raw("4 as type"))
                    ->latest('aes_feature.updated_at');
        }
        
        if ($query == null) {
        $measureQuery = DB::table('aes_measure')
                    ->join('aes_measure_lang', 'aes_measure.id', '=', 'aes_measure_lang.measure_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_measure_lang.language_id')
                    ->where('aes_measure_lang.language_id', '=', $language)
                    ->select('aes_measure.id', 'aes_measure_lang.name', DB::raw("5 as type"))
                    ->latest('aes_measure.updated_at')
                    ->take(10);
        } else {
        $measureQuery = DB::table('aes_measure')
                    ->join('aes_measure_lang', 'aes_measure.id', '=', 'aes_measure_lang.measure_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_measure_lang.language_id')
                    ->where('aes_measure_lang.language_id', '=', $language)
                    ->where('aes_measure_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_measure.id', 'aes_measure_lang.name', DB::raw("5 as type"))
                    ->latest('aes_measure.updated_at');
        }
        
        if ($query == null) {
        $countryQuery = DB::table('aes_country')
                    ->join('aes_country_lang', 'aes_country.id', '=', 'aes_country_lang.country_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_country_lang.language_id')
                    ->where('aes_country_lang.language_id', '=', $language)
                    ->select('aes_country.id', 'aes_country_lang.name', DB::raw("6 as type"))
                    ->latest('aes_country.updated_at')
                    ->take(10);
        } else {
        $countryQuery = DB::table('aes_country')
                    ->join('aes_country_lang', 'aes_country.id', '=', 'aes_country_lang.country_id')
                    ->join('ps_lang', 'ps_lang.id_lang', '=', 'aes_country_lang.language_id')
                    ->where('aes_country_lang.language_id', '=', $language)
                    ->where('aes_country_lang.name', 'like', '%'.$query.'%')
                    ->select('aes_country.id', 'aes_country_lang.name', DB::raw("6 as type"))
                    ->latest('aes_country.updated_at');  
        }
        
        if ($type == null || $type == "all")
            return $productQuery->union($ingredientQuery)
                            ->union($nutrientQuery)
                            ->union($tagQuery)
                            ->union($featureQuery)
                            ->union($measureQuery)
                            ->union($countryQuery)
                            ->get();
        else {
            if ($type == 'ingredient')
                return $ingredientQuery->get();
            if ($type == 'manufacturer')
                return Manufacturer::all();
        }
    }
}
