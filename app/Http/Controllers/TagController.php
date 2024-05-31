<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use DB;

use App\Http\Requests;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Tag::with(['info' => function($query) {
            $query->select(['aes_tag_lang.name', 'aes_tag_lang.language_id']);
        }])->get();;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            $parent_id = $data['tag_id'];
            $names = $data['names'];
            $tag = new Tag();

            // add parent
            if ($parent_id !== null && $parent_id !== 0) {
                $tag->tag_id = $parent_id;
            }

            $tag->save();

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                $tag->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $tag->save();
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
        return Tag::with(['info' => function($query) {
            $query->select(['aes_tag_lang.name', 'aes_tag_lang.language_id']);
        }, 'parent'])->find($id);;
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
            $parent_id = $data['tag_id'];
            $names = $data['names'];
            $tag = Tag::find($id);

            // add parent
            if ($parent_id !== null && $parent_id !== 0) {
                $tag->tag_id = $parent_id;
            }

            // update names
            foreach($names as $name) {
                if ($name['value'] == "")
                    $name['value'] = "Missing";
                if ($tag->info()->get(['language_id'])->contains('language_id', $name['language']['id']))
                    $tag->info()->updateExistingPivot($name['language']['id'], array('name' => $name['value']));
                else
                    $tag->info()->attach($name['language']['id'], array('name' => $name['value']));
            }
            
            $tag->save();
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
            $tag = Tag::find($id);
            $tag->info()->detach();
            $tag->delete();
        });
    }
}
