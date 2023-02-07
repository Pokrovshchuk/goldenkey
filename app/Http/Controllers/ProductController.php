<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('count', '>', 0)->get();
        $halls = Hall::all();


        return view('admin.products.index', [
            'products' => $products,
            'halls' => $halls,
        ]);
    }

    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'count' => $request->count,
            'price' => $request->price,
            'hall_id' => $request->hall_id,
        ]);

        return redirect()->back();
    }
}
