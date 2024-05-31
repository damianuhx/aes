<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Language;
use App\Measure;

class Nutrient extends Model
{
    protected $table = 'aes_nutrient';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_nutrient_lang', 'nutrient_id', 'language_id')->withPivot('name');
    }

    public function measure() {
        return $this->belongsTo('App\Measure', 'measure_id');
    }

    /* public function products() {
        return $this->belongsToMany('App/Products');
    } */

}