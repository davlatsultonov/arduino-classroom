<?php

namespace App\Services;

use Illuminate\Support\Facades\Facade;

class BaseService extends Facade
{
    /**
     * Получает название записи по его slug.
     *
     * @param string $modelClass - имя класса модели
     * @param mixed $slug - slug записи
     * @return string - название записи
     */
    public static function getRecordNameBySlug(String $modelClass, $slug)
    {
        $model = new $modelClass();
        return $model::firstWhere('slug', $slug)->name;
    }
}

