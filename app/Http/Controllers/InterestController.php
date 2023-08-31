<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;

class InterestController extends Controller
{
    public function index()
    {
        $interest = Interest::all();

        return response()->json($interest);
    }

    public function store(Request $request)
    {
        $request->validate([
            'interest' => 'required|max:255',
        ]);

        $interest = Interest::create($request->all());

        return response()->json($interest);
    }

    public function update(Request $request, Interest $interest)
    {
        $request->validate([
            'interest' => 'required|max:255',
        ]);

        $interest->update($request->all());

        return response()->json($interest);
    }

    public function destroy(Interest $interest)
    {
        $interest->delete();

        return response()->json(['message' => 'Deleted Successfully']);
    }
}
