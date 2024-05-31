<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'aes_tag';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_tag_lang', 'tag_id', 'language_id')->withPivot('name');
    }
    
    public function parent() {
        return $this->belongsTo('App\Tag', 'tag_id');
    }

    public function children() {
        return $this->hasMany('App\Tag');
    }
}