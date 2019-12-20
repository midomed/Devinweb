<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0 ; $i<15;$i++) {
            $category = new \App\Category();
            $data= ['name'=>'name'.$i,'slug'=>'slug'.$i];
            $category->fill($data);
            $category->save();
        }
    }
}
