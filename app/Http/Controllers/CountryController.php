<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Country;
use DB;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Country::with(['info' => function($query)
        {
            $query->select(['aes_country_lang.name', 'aes_country_lang.language_id']);

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
            $names = $data['names'];
            $country = new Country();

            if ($code === null || $code == "") {
                return response()->json("Country (Code) is mandatory.", 500);
            } else {
                $country->code = $code;
            }

            $country->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";

                $country->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $country->touch();
            $country->save();
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
        return Country::with(['info' => function($query)
        {
            $query->select(['aes_country_lang.name', 'aes_country_lang.language_id']);

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
            $names = $data['names'];
            $country = Country::find($id);

            if ($code == null || $code == "") {
                return response()->json("Country (Code) is mandatory.", 500);
            } else {
                $country->code = $code;
            }

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                if ($country->info()->get(['language_id'])->contains('language_id', $name['language']['id']))
                    $country->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                else
                    $country->info()->attach($name['language']['id'], array('name' => $name['value']));
            }

            $country->save();
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
            $country = Country::find($id);
            $country->info()->detach();
            $country->delete();
        });
    }
}
