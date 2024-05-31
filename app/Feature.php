<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'aes_feature';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_feature_lang', 'feature_id', 'language_id')->withPivot('name');
    }

    public function tag() {
        return $this->belongsTo('App\Tag');
    }

}