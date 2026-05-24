<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $products = config('products');
        $destaques = [];
        foreach ($products['destaques'] as $key) {
            [$category, $index] = explode('.', $key);
            $destaques[] = array_merge($products[$category][(int) $index], ['category' => $category]);
        }
        return view('home', compact('destaques'));
    }
}
