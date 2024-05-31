<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    protected $table = 'aes_manufacturer';

    protected $hidden = array('created_at', 'updated_at');

    public function products() {
        return $this->hasMany('App\Product');
    }

}