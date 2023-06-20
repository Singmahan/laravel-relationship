<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }
    public function create(){
        return view('category.create');
    }
    public function store(Request $request){
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect('category')->with('message','Category Added');
    }
    public function destroy(int $category_id){
        Category::findOrFail($category_id)->delete();
        return redirect('category')->with('message','Category Delete with all its products');
    }
}
