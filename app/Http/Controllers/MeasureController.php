<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Measure;
use DB;

class MeasureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Measure::with(['info' => function($query)
        {
            $query->select(['aes_measure_lang.name', 'aes_measure_lang.language_id']);

        }])->get();
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
            $code = $data['code'];
            $short = $data['short'];
            $names = $data['names'];
            $measure = new Measure();

            if ($short === null || $short == "") {
                return response()->json("Measure (Short) is mandatory.", 500);
            } else {
                $measure->short = $short;
            }

            if ($code === null || $code == "") {
                return response()->json("Measure (Code) is mandatory.", 500);
            } else {
                $measure->code = $code;
            }

            $measure->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";

            $measure->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $measure->save();
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
        return Measure::with(['info' => function($query)
        {
            $query->select(['aes_measure_lang.name', 'aes_measure_lang.language_id']);

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
            $code = $data['code'];
            $short = $data['short'];
            $names = $data['names'];
            $measure = Measure::find($id);

            if ($short === null || $short == "") {
                return response()->json("Measure (Short) is mandatory.", 500);
            } else {
                $measure->short = $short;
            }

            if ($code === null || $code == "") {
                return response()->json("Measure (Code) is mandatory.", 500);
            } else {
                $measure->code = $code;
            }

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                if ($measure->info()->get(['language_id'])->contains('language_id', $name['language']['id']))
                    $measure->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                else
                    $measure->info()->attach($name['language']['id'], array('name' => $name['value']));
            }

            $measure->save();
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
            $measure = Measure::find($id);
            $measure->info()->detach();
            $measure->delete();
        });
    }
}
