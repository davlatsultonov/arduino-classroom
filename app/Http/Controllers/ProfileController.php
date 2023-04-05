<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function index()
    {
        return inertia('Profile/Index', [
            'name' => \Auth::user()->name
        ]);
    }
}
