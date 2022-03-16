<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = "id";

    public function productGroups()
    {
        return $this->hasMany(ProductGroup::class);
    }

    public static function saveCategory($request)
    {

        $category = new self;
        $category->name = $request['name'];
        $category->code = $request['code'];

        if ($category->save()) {
            return true;
        }

        return false;
    }

    public static function updateUser($request, $id)
    {
        $category = self::findOrFail($id);
        $category->name = $request['name'];
        $category->code = $request['code'];

        if ($category->save()) {
            return true;
        }

        return false;
    }


    public static function getCategoryDetail($id)
    {
        $category = self::find($id);
        return $category;
    }
}
