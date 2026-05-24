<?php

namespace App\Http\Controllers;

class CategoryController extends Controller
{
    public function show(string $category)
    {
        $products = config("products.{$category}");
        abort_if($products === null, 404);
        return view("categories.{$category}", compact('products'));
    }
}
