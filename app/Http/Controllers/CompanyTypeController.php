<?php

namespace App\Http\Controllers;

use App\Models\CompanyType;
use Illuminate\Http\Request;

class CompanyTypeController extends Controller
{
    public function index()
    {
        $companyType = CompanyType::all();

        return response()->json($companyType);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $companyType = CompanyType::create($request->all());

        return response()->json($companyType);
    }

    public function update(Request $request, CompanyType $companyType)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $companyType->update($request->all());

        return response()->json($companyType);
    }

    public function destroy(CompanyType $companyType)
    {
        $companyType->delete();

        return response()->json(['message' => 'Successfully deleted']);
    }
}
