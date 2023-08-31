<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminLocationController extends Controller
{
    public function index()
    {
        $locations = Location::all();

        foreach ($locations as $location) {
            $location->in_use = DB::table('companies')
                ->where('location_id', $location->id)
                ->orWhereExists(function ($query) use ($location) {
                    $query->select(DB::raw(1))
                        ->from('jobs')
                        ->whereRaw('jobs.location_id = companies.location_id')
                        ->where('jobs.location_id', $location->id);
                })
                ->exists();
        }

        return view('admin.settings.location', compact('locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $location = Location::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $location->update($request->all());

       return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return redirect()->back();
    }
}
