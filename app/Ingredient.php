<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    protected $table = 'aes_ingredient';

    public function info() {
        return $this->belongsToMany('App\Language', 'aes_ingredient_lang', 'ingredient_id', 'language_id')->withPivot('name');
    }

    public function features() {
        return $this->belongsToMany('App\Feature', 'aes_ingredient_feature', 'ingredient_id', 'feature_id');
    }

    public function children() {
        return $this->belongsToMany('App\Ingredient', 'aes_ingredient_rel', 'parent_id', 'child_id')->withPivot('position', 'amount', 'country_id');
    }
}