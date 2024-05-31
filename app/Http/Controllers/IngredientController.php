<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ingredient;
use DB;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ingredient::with(['info' => function($query) {
            $query->select(['aes_ingredient_lang.name', 'aes_ingredient_lang.language_id']);
        }])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->input('data');

            $id = $data['id'];
            $code = $data['code'];
            $features = $data['features'];
            $children = $data['children'];
            $names = $data['names'];
            $parent = isset($data['isContainer']) ? $data['isContainer'] : 0;

            $ingredient = new Ingredient();
            $ingredient->code = $code;
            $ingredient->parent = (int)$parent;

            $ingredient->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                $ingredient->info()->attach($name['language']['id'], array('name' => $name['value']));
            }

            foreach($features as $feature) {
                if ($feature['id'] > 0)
                    $ingredient->features()->attach($feature['id']);
            }

            foreach($children as $child) {
                if ($child['id'] > 0)
                    $ingredient->children()->attach($child['id']);
            }
            
            $ingredient->touch();
            $ingredient->save();
            
            return Ingredient::with(['info' => function($query)
            {
                $query->select(['aes_ingredient_lang.name', 'aes_ingredient_lang.language_id']);
            }])->find($ingredient->id);
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Ingredient::with(['info' => function($query)
        {
            $query->select(['aes_ingredient_lang.name', 'aes_ingredient_lang.language_id']);

        }, 'features.info' => function($query) {
            $query->select(['aes_feature_lang.name', 'aes_feature_lang.language_id']);
        }, 'children.info'
        ])->find($id);
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
            $id = $data['id'];
            $code = $data['code'];
            $features = $data['features'];
            $children = $data['children'];
            $parent = isset($data['isContainer']) ? $data['isContainer'] : 0;
            $names = $data['names'];

            $ingredient = Ingredient::find($id);
            $ingredient->code = $code;
            $ingredient->parent = (int)$parent;

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                if ($ingredient->info()->get(['language_id'])->contains('language_id', $name['language']['id']))
                    $ingredient->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                else
                    $ingredient->info()->attach($name['language']['id'], array('name' => $name['value']));
            }

            $ingredient->features()->detach();
            foreach($features as $feature) {
                $ingredient->features()->attach($feature['id']);
            }

            $ingredient->children()->detach();
            if ($ingredient->parent) {
                foreach($children as $child) {
                    $ingredient->children()->attach($child['id']);
                }
            }
            
            $ingredient->touch();
            $ingredient->save();

            return Ingredient::with(['info' => function($query)
            {
                $query->select('aes_ingredient_lang.name');

            }, 'children.info'
            ])->find($ingredient->id);
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
        DB::transaction(function() use ($id)  {
            $ingredient = Ingredient::find($id);
            $ingredient->info()->detach();
            $ingredient->delete();
        });
    }
}
