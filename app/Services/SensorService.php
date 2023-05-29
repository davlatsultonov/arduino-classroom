<?php

namespace App\Services;

use App\Models\Sensor;
use Illuminate\Support\Facades\Facade;

class SensorService extends Facade
{
    /**
     * Получает все датчики.
     *
     * @return \Illuminate\Database\Eloquent\Collection - коллекция всех датчиков
     */
    public static function getAllSensors()
    {
        return Sensor::all();
    }
}

