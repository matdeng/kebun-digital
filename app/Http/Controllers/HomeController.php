<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()->featured()->inStock()->with('category')->take(8)->get();
        $categories = Category::where('is_active', true)->withCount('activeProducts')->get();
        $latestProducts = Product::active()->inStock()->with('category')->latest()->take(8)->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}
