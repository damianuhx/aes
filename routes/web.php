<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 404 
Route::get('product/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('product/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('ingredient/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('ingredient/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('nutrient/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('nutrient/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('tag/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('tag/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('feature/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('feature/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('measure/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('measure/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('country/edit/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('country/new/{id?}', function ($name = null, $id = 0) {
    return view('welcome');
});

Route::get('settings', function ($name = null, $id = 0) {
    return view('welcome');
});


// regular 
Route::get('search', 'SearchController@search');

Route::resource('language', 'LanguageController', ['only' => [
    'index', 'update'
]]);

Route::resource('product', 'ProductController', ['only' => [
    'index', 'show', 'update',
]]);

Route::resource('ingredient', 'IngredientController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('nutrient', 'NutrientController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('tag', 'TagController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('feature', 'FeatureController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('measure', 'MeasureController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy'
]]);

Route::resource('country', 'CountryController', ['only' => [
    'index', 'store', 'show', 'update', 'destroy',
]]);

// additional
Route::get('generate', 'DescriptionGeneratorController@generate');
