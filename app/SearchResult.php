<?php

namespace App;


class SearchResult
{
    public $id;

    public $name;

    public $type;

    function __construct($id, $name, $type) {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }
}