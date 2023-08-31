<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $location = Location::all();

        return response()->json($location);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $location = Location::create($request->all());

        return response()->json($location, 201);
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $location->update($request->all());

        return response()->json($location);
    }

    public function destroy(Location $location)
    {
        $location->delete();

        return response()->json(['message' => 'Successfully deleted']);
    }
}
