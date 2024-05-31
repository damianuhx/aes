<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'ps_product';

    protected $primaryKey = 'id_product';

    protected $hidden = array('created_at', 'updated_at');

    public function info() {
        return $this->belongsToMany('App\Language', 'ps_product_lang', 'id_product', 'id_lang')->withPivot('name', 'text', 'posttext');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag', 'aes_product_tag', 'product_id', 'tag_id');
    }

    public function ingredients() {
        return $this->belongsToMany('App\Ingredient', 'aes_product_ingredient', 'product_id', 'ingredient_id')->withPivot('position','amount', 'country_id');
    }

    public function nutrients() {
        return $this->belongsToMany('App\Nutrient', 'aes_nutrient_product', 'product_id', 'nutrient_id')->withPivot('amount');
    }

    public function manufacturer() {
        return $this->belongsTo('App\Manufacturer');
    }

}