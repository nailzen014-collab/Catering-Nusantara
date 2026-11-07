<?php

namespace App\Http\Controllers;

use App\Models\Menu;

class LandingController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->inRandomOrder()->take(24)->get();

        $categories = $menus
            ->map(fn (Menu $menu) => $menu->category?->name)
            ->filter()
            ->unique()
            ->sort()
            ->values();

        return view('landing.index', compact('menus', 'categories'));
    }
}
