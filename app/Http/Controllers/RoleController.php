<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.index', [
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        Role::create(['name' => $request->name]);

        return redirect()->back();
    }

    public function delete(Request $request)
    {
        Role::where('id', $request->id)->delete();

        return redirect()->back();
    }
}
