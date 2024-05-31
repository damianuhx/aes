<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Nutrient;
use DB;

class NutrientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Nutrient::with(['info' => function($query) {
            $query->select(['aes_nutrient_lang.name', 'aes_nutrient_lang.language_id']);
        }, 'measure'
        ])->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Nutrient::with(['info' => function($query) {
            $query->select(['aes_nutrient_lang.name', 'aes_nutrient_lang.language_id']);
        }, 'measure'
        ])->find($id);
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
            $dailyrec = $data['dailyrec'];
            $calories = $data['calories'];
            $measure_id = $data['measure_id'];
            $names = $data['names'];

            $nutrient = new Nutrient();
            $nutrient->dailyrec = $dailyrec;
            $nutrient->calories = $calories;

            // add measure
            if ($measure_id !== null && $measure_id !== 0) {
                $nutrient->measure_id = $measure_id;
            } else {
                $nutrient->measure_id = 1;
            }

            $nutrient->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                $nutrient->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $nutrient->save();
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
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
            $dailyrec = $data['dailyrec'];
            $calories = $data['calories'];
            $measure_id = $data['measure_id'];
            $names = $data['names'];

            $nutrient = Nutrient::find($id);
            $nutrient->dailyrec = $dailyrec;
            $nutrient->calories = $calories;

            // add measure
            if ($measure_id !== null && $measure_id !== 0) {
                $nutrient->measure_id = $measure_id;
            }

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                if ($nutrient->info()->get(['language_id'])->contains('language_id', $name['language']['id']))
                    $nutrient->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                else
                    $nutrient->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $nutrient->save();
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
            $nutrient = Nutrient::find($id);
            $nutrient->info()->detach();
            $nutrient->delete();
        });
    }
}
