<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceRequest;
use App\Models\Hall;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('type', 'main')->get();
        $add_services = Service::where('type', 'add')->get();
        foreach ($add_services as $service) {
            if ($service->content) {
                $service->content = json_decode($service->content);
            }
        }

        $halls = Hall::all();
        return view('admin.services.index',
            ['services' => $services, 'add_services' => $add_services, 'halls' => $halls]
        );
    }

    public function store(ServiceRequest $request)
    {
        if ($request->file('icon')) {
            $path = $request->file('icon')->store('services', 'public');
        } else {
            $path = '';
        }

        $service = Service::create(
            [
                'name' => $request->name,
                'icon' => 'storage/' . $path,
                'type' => $request->type,
                'text' => $request->text,
            ]
        );

        $service->hall()->sync($request->hall_id);

        return back();
    }

    public function edit(Request $request)
    {
        $service = Service::where('id', $request->id)->first();

        if(!$service){
            abort(200, 'Сервис не выбран или произошла ошибка.');
        }

        $service = $request->all();
        $service->save();

        return back();
    }

    public function remove(Request $request)
    {
        Service::where('id', $request->service_id)->delete();
        return back();
    }

    public function addContent(Request $request)
    {
        $service = Service::where('id', $request->add_service_id)->first();
        $service->content = $request->all();
        $service->save();

        return back();
    }
}
