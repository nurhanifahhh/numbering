<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    use HasFactory;
    protected $table = "product_groups";
    protected $guarded = "id";

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public static function saveProductGroup($request)
    {

        $productGroup = new self;
        $productGroup->category_id = $request['category_id'];
        $productGroup->name = $request['name'];
        $productGroup->numberCode = $request['numberCode'];

        if ($productGroup->save()) {
            return true;
        }

        return false;
    }

    public static function updateUser($request, $id)
    {
        $productGroup = self::findOrFail($id);
        $productGroup->category_id = $request['category_id'];
        $productGroup->name = $request['name'];
        $productGroup->numberCode = $request['numberCode'];

        if ($productGroup->save()) {
            return true;
        }

        return false;
    }


    public static function getProductGroupDetail($id)
    {
        $productGroup = self::findOrFail($id);
        return $productGroup;
    }
}
