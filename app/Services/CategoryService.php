<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Facade;

class CategoryService extends Facade
{
    public static function getAllCategories()
    {
        return Category::get();
    }
}

