<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'aes_country';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_country_lang', 'country_id', 'language_id')->withPivot('name');
    }

    public function ingredients() {
        return $this->hasMany('App\Ingredient');
    }

    public function products() {
        return $this->hasMany('App\Product')    ;
    }

}