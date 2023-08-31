<?php

namespace App\Http\Controllers;

use App\Models\CompanyType;
use App\Models\Company;
use Illuminate\Http\Request;

class AdminCompanyTypeController extends Controller
{
    public function index()
    {
        $companyTypes = CompanyType::all();

        foreach ($companyTypes as $companyType) {
            $companyType->in_use = Company::where('company_type_id', $companyType->id)->exists();
        }

        return view('admin.settings.companytype', compact('companyTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $companyType = CompanyType::create($request->all());

        return redirect()->back();
    }

    public function update(Request $request, CompanyType $companyType)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $companyType->update($request->all());

        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        $companyType = CompanyType::findOrFail($id);
        $companyType->delete();

        return redirect()->back();
    }
}
