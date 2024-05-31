<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'ps_lang';

    protected $hidden = array('pivot', 'created_at', 'updated_at');

    protected $primaryKey = 'id_lang';
}