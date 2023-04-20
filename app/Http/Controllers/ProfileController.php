<?php

namespace App\Http\Controllers;

use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function index()
    {
        return inertia('Profile/Index', [
            'name' => \Auth::user()->name,
            'totalPointsCount' => ProfileService::getTotalPointsCount(),
            'currentPointsCount' => ProfileService::getCurrentPointsCount()
        ]);
    }
}
