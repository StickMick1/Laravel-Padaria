<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'ativo')->paginate(9);
        return view('catalog.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('catalog.show', compact('product'));
    }
}
