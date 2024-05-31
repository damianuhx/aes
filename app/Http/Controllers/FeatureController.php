<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Feature;
use DB;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Feature::with(['info' => function($query) {
            $query->select(['aes_feature_lang.name', 'aes_feature_lang.language_id']);
        }])->select('id')->get();
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
        try {
            $data = $request->input('data');
            $id = $data['id'];
            $rule = $data['rule'];
            $tag_id = $data['tag_id'];
            $names = $data['names'];

            $feature = new Feature();
            $feature->rule = $rule;

            // add measure
            if ($tag_id !== null && $tag_id !== 0) {
                $feature->tag_id = $tag_id;
            } else {
                $feature->tag_id = 1;
            }

            $feature->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                $feature->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $feature->save();
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
        return Feature::with(['info' => function($query) {
            $query->select(['aes_feature_lang.name', 'aes_feature_lang.language_id']);
        }])->find($id);
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
            $id = $data['id'];
            $rule = $data['rule'];
            $tag_id = $data['tag_id'];
            $names = $data['names'];

            $feature = Feature::find($id);
            $feature->rule = $rule;

            // add measure
            if ($tag_id !== null && $tag_id !== 0) {
                $feature->tag_id = $tag_id;
            }

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                
                $toUpdate = $feature->info()->get(['language_id'])->contains('language_id', $name['language']['id']);
                if ($toUpdate) {
                    $feature->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                }
                else {
                    $feature->info()->attach($name['language']['id'], array('name' => $name['value']));
                }
            }

            $feature->save();
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
            $feature = Feature::find($id);
            $feature->info()->detach();
            $feature->delete();
        });
    }
}
