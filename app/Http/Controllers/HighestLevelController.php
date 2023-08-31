<?php

namespace App\Http\Controllers;

use App\Models\HighestLevel;
use Illuminate\Http\Request;
class HighestLevelController extends Controller
{
    public function index()
    {
        $highestLevel = HighestLevel::all();

        return response()->json($highestLevel);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $highestLevel = HighestLevel::create($request->all());

        return response()->json($highestLevel, 201);
    }

    public function update(Request $request, HighestLevel $highestLevel)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $highestLevel->update($request->all());

        return response()->json($highestLevel);
    }

    public function destroy(HighestLevel $highestLevel)
    {
        $highestLevel->delete();

        return response()->json(['message' => 'Successfully deleted']);
    }
}
