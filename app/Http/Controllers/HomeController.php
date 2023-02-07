<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hall;
use App\Models\Service;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $halls = Hall::with('cities')
            ->with([
                'media' => function($query) {
                    $query->select('id', 'url', 'hall_id');
                },
                'product' => function($query) {
                    $query->select('id', 'price', 'hall_id');
                },
                'services'
            ])
            ->get();


        $services = Service::where('type', 'main')->get();

        return response()->json([
            'halls' => $halls,
            'services' => $services,
        ]);
    }
}
