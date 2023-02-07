<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\City;
use App\Models\Hall;
use App\Models\Media;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use function auth;

class HallController extends Controller
{
    public function index()
    {
        $halls = Hall::all();
        $services = Service::all();
        $admins = User::whereHas('role', function ($query) {
            $query->where('name', 'admin');
        })->get();
        $cities = City::all();

        return view('admin.halls.index', [
            'halls' => $halls,
            'users' => $admins,
            'cities' => $cities,
            'services' => $services
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $hall = Hall::updateOrCreate(
            ['name' => $request->name],
            [
                'name' => $request->name,
                'admin_name' => $request->admin_name,
                'description' => $request->description,
                'working_time' => $request->working_time,
                'location' => $request->location,
                'city_id' => $request->city_id,
                'user_id' => $request->user_id,
            ]);
        $photos = $request->file('photos');

        if ($photos) {
            foreach ($photos as $photo) {

                $path = $photo->store('media', 'public');
                $photoResize = Image::make('storage/' . $path)->encode('jpg', 80);
                $photoResize->resize(1920, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $photoResize->save('storage/' . $path);

                Media::create([
                    'url' => 'storage/' . $path,
                    'hall_id' => $hall->id
                ]);
            }
        }

        return back();
    }

    public function edit(Request $request)
    {
        $hall = Hall::where('id', $request->hall_id)->firstOrfail();
        $hall->user_id = $request->user_id;
        $hall->save();

        return back();
    }

    public function hallWithActiveCertificates(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
                'status' => 'success',
                'data' => Hall::getHallWithCertificatesByUser()
            ]
        );
    }

    public static function getCertificatesByHallFilters($hall_id, $request)
    {
        return Certificate::select('id', 'status', 'hall_id', 'user_id', 'start_time', 'table_number', 'description', 'pass_limit', 'code', 'user_name')
            ->where('hall_id', $hall_id)
            ->with('halls')
            ->with('user')
            ->filter($request)
            ->orderBy('start_time', 'desc')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc');
    }

    public function hallRegisterList(Request $request): \Illuminate\Http\JsonResponse
    {
        $hall = Hall::where('user_id', auth()->user()->id)->first();

        $certificates = self::getCertificatesByHallFilters($hall->id, $request)
            ->paginate(10)
            ->withQueryString();

        $hall->certificates_sum_pass_limit = Certificate::where('hall_id', $hall->id)->filter($request)->sum('pass_limit');

        return response()->json([
                'status' => 'success',
                'data' => [
                    'hall' => $hall,
                    'certificates' => $certificates,
                ]
            ]
        );
    }

    public function addServiceToHalls(Request $request)
    {
        $hall = Hall::where('id', $request->id)->first();
        $hall->services()->sync($request->hall_service);

        return back();
    }
}
