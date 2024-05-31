<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Measure extends Model
{
    protected $table = 'aes_measure';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_measure_lang', 'measure_id', 'language_id')->withPivot('name');
    }

    public function products() {
        return $this->hasMany('App\Product');
    }

    public function nutrients() {
        return $this->hasMany('App\Nutrient');
    }

}