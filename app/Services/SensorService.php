<?php

namespace App\Services;

use App\Models\Sensor;
use Illuminate\Support\Facades\Facade;

class SensorService extends Facade
{
    public static function getAllSensors()
    {
        return Sensor::all();
    }
}

