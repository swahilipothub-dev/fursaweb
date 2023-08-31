<?php

namespace App\Http\Controllers;
use App\Models\SeekerProfile;

use App\Models\HighestLevel;
use Illuminate\Http\Request;

class AdminHighestLevelController extends Controller
{

    public function index()
    {
        $highestLevels = HighestLevel::all();

        foreach ($highestLevels as $level) {
            $level->in_use = SeekerProfile::where('highest_level_id', $level->id)->exists();
        }

        return view('admin.settings.level', compact('highestLevels'));
 
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $highestLevel = HighestLevel::create($request->all());

       return redirect()->back();
    }

    public function update(Request $request, HighestLevel $highestLevel)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $highestLevel->update($request->all());

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $level = HighestLevel::findOrFail($id);
        $level->delete();

        return redirect()->back();
    }
}
