<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class LandingController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->inRandomOrder()->take(6)->get();

        return view('landing.index', compact('menus'));
    }
}