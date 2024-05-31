<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;

class DescriptionGeneratorController extends Controller
{
    public function generate() {
        /*
        Product::with(['info' => function($query) {
            $query->select(['ps_product_lang.id_lang as language_id','ps_product_lang.name', 'ps_product_lang.text', 'ps_product_lang.posttext']);
        }, 'manufacturer', 'ingredients.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }, 'nutrients.info', 'tags.info'
        ])->with(['ingredients.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->with(['ingredients.children.children.children.children.info' => function($query) {
            $query->select(['aes_ingredient_lang.language_id', 'aes_ingredient_lang.name']);
        }])
        ->find($id, ['ps_product.id_product as id', 'ps_product.*']);
        */
        dd("Generate code");
    }
}
