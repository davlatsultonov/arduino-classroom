<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class BaseService extends Facade
{
    public static function getRecordNameBySlug(String $modelClass, $slug)
    {
        $model = new $modelClass();
        return $model::firstWhere('slug', $slug)->name;
    }
}

