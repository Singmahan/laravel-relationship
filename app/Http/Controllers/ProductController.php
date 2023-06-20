<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return view('product.index', compact('products'));
    }
    public function create(){
        // ใช้เพื่อทำการ select option ข้อมูลประเภท
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }
    public function store(Request $request){
        // ใช้เพื่อทำการ select option ข้อมูลประเภท
        $category = Category::findOrFail($request->category_id);

        $product = new Product;
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug);
        $product->price = $request->price;
        $category->products()->save($product);

        // $category->products()->create([
        //     'name' => $request->name,
        //     'slug' => Str::slug($request->slug),
        //     'price' => $request->price,
        // ]);
        return redirect('products')->with('message','Product created');
    }
    public function edit(int $product){
        $categories = Category::all();
        $product = Product::findOrFail($product);
        return view('product.edit', compact('categories','product'));
    }
    public function update(Request $request, $product_id){
        // $product = Category::findOrFail($request->category_id)
        // ->products()->where('id', $product_id)->first();

        // $product->name = $request->name;
        // $product->slug = Str::slug($request->slug);
        // $product->price = $request->price;
        // $product->update();

        $category = Category::findOrFail($request->category_id);
        $category->products()->where('id', $product_id)->update([
            'name' => $request->name,
            'slug' => Str::slug($request->slug),
            'price' => $request->price,
        ]);
        return redirect('products')->with('message','Product Updated');
    }
}
