<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function getRecordNameBySlug(String $modelClass, $slug)
    {
        $model = new $modelClass();
        return $model::firstWhere('slug', $slug)->name;
    }
}
