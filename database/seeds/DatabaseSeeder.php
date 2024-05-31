<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(LanguageTableSeeder::class);
        $this->call(TagTableSeeder::class);
        $this->call(MeasureTableSeeder::class);
        $this->call(NutrientTableSeeder::class);
        $this->call(FeatureTableSeeder::class);
        $this->call(CountryTableSeeder::class);
        $this->call(IngredientTableSeeder::class);
        //$this->call(ProductTableSeeder::class);
    }
}
