<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function store(Request $request)
    {
        City::create([
            'name' => $request->city_name,
        ]);

        return back();
    }

    public function getAll()
    {
        $cities = City::all();
        return view('admin.cities.index', ['cities' => $cities]);
    }
}
