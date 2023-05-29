<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\Facade;

class CategoryService extends Facade
{
    /**
     * Получает все категории.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция всех категорий
     */
    public static function getAllCategories()
    {
        return Category::get();
    }
}

