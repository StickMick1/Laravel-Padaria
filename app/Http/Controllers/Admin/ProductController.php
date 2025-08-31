<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'unit_price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image'
        ]);

        $path = $request->file('image')?->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'category_id' => $request->category_id,
            'unit_price' => $request->unit_price,
            'status' => $request->status ?? 'ativo',
            'image_path' => $path,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto criado!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'unit_price' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $path = $request->file('image')?->store('products', 'public');

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'unit_price' => $request->unit_price,
            'status' => $request->status,
            'image_path' => $path ?? $product->image_path,
        ]);

        return redirect()->route('products.index')->with('success', 'Produto atualizado!');
    }

    public function show($id)
    {
        $product = Product::with('stockMovements')->findOrFail($id);

        // ordena as movimentações mais recentes primeiro
        $movements = $product->stockMovements()->orderBy('created_at', 'desc')->get();

        return view('products.show', compact('product', 'movements'));
    }

    public function destroy(Product $product)
    {
        $product->update(['status' => 'inativo']);
        return redirect()->route('products.index')->with('success', 'Produto desativado!');
    }
}
