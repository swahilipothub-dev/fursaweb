<?php

namespace App\Http\Controllers;

use App\Models\Interest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminInterestController extends Controller
{
    public function index()
    {
        $interests = Interest::all();

        foreach ($interests as $interest) {
            $interest->in_use = DB::table('seeker_interests')
                ->where('interest_id', $interest->id)
                ->exists();
        }

        return view('admin.settings.interest', compact('interests'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'interest' => 'required|max:255',
        ]);

        $interest = Interest::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, Interest $interest)
    {
        $request->validate([
            'interest' => 'required|max:255',
        ]);

        $interest->update($request->all());

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $interest = Interest::findOrFail($id);
        $interest->delete();

        return redirect()->back();
    }
}
