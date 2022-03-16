<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\ProductGroup;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create category user
        $category = new Category;
        $category->name = "CRB";
        $category->code = "CRB";
        $category->save();

        $product = new ProductGroup();
        $product->category_id = $category->id;
        $product->name = "APD";
        $product->numberCode = "1000";
        $product->save();

        $product = new ProductGroup();
        $product->category_id = $category->id;
        $product->name = "CCD/RT";
        $product->numberCode = "2000";
        $product->save();

        $product = new ProductGroup();
        $product->category_id = $category->id;
        $product->name = "Ceramic";
        $product->numberCode = "3000";
        $product->save();

        $category = new Category;
        $category->name = "ECN";
        $category->code = "ECN";
        $category->save();

        $product = new ProductGroup();
        $product->category_id = $category->id;
        $product->name = "Cermax";
        $product->numberCode = "4000";
        $product->save();

        $product = new ProductGroup();
        $product->category_id = $category->id;
        $product->name = "Admin";
        $product->numberCode = "4000";
        $product->save();

    }
}
