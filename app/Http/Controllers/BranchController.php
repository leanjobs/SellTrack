<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->input('search');
            if($search){
                $branches = Branch::where('branch_name', 'like', '%' .$search. '%')->get();
            }else{
                $branches = Branch::all();
            }
            return view('branches.branches', compact('branches'));

        }catch(Exception $e){
            Log::info($e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // // Ambil data dari API
        // $response = Http::get('https://alamat.thecloudalert.com/api/provinsi/get/');

        // // Pastikan response di-decode ke array
        // $province_data = $response->json('result'); // Ambil hanya bagian 'result'
        $users = User::where('status', 'active')->get();
        return view('branches.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'branch_name' => 'string|required',
                'province' => 'string|required',
                'city' => 'string|required',
                'sub_district' => 'string|required',
                'postal_code' => 'string|required',
                'address' => 'string|required',
                'phone_number' => 'string|required|min:10',
                // 'users_id' => 'required|exists:users,id',
                'status' => 'required|in:active,inactive'
            ]);
            $branch = Branch::create($validated);

            //create branch code
            $branch_id = str_pad($branch->id, 3, '0', STR_PAD_LEFT);
            $parts_city = explode('_', $branch->city);
            $parts_province = explode('_', $branch->province);
            $parts_sub_district = explode('_', $branch->sub_district);
            $city_name = $parts_city[0] ?? $branch->city;
            $province_name = $parts_province[0] ?? $branch->province;
            $sub_district_name = $parts_sub_district[0] ?? $branch->sub_district;
            $branch_code = "{$branch_id}-{$province_name}-{$city_name}-{$sub_district_name}";

            $branch->update(['branch_code' => $branch_code]);
            return redirect()->route('branches.index')->with('success', 'Branch created successfully');
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('branches.index')->with('error', 'Branch Failed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $provinceParts = explode('_', $branch->province);
        $province = $provinceParts['0'] ?? null;
        $cityParts = explode('_', $branch->city);
        $city = $cityParts['0'] ?? null;
        $subDistrictParts = explode('_', $branch->sub_district);
        $subDistrict = $subDistrictParts['0'] ?? null;
        $postalCodeParts = explode('_', $branch->postal_code);
        $postalCode = $postalCodeParts['0'] ?? null;
        return view('branches.update', compact(['branch', 'province', 'city', 'subDistrict', 'postalCode']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Branch $branch)
    {
        try {
            $validated = $request->validate([
                'branch_name' => 'string|required',
                'province' => 'string|required',
                'city' => 'string|required',
                'sub_district' => 'string|required',
                'postal_code' => 'string|required',
                'address' => 'string|required',
                'phone_number' => 'string|required|min:10',
                // 'users_id' => 'requires|exists:users,id',
                'status' => 'required|in:active,inactive'
            ]);
            $branch->update($validated);

            //create branch code
            $branch_id = str_pad($branch->id, 3, '0', STR_PAD_LEFT);
            $parts_city = explode('_', $branch->city);
            $parts_province = explode('_', $branch->province);
            $parts_sub_district = explode('_', $branch->sub_district);
            $city_name = $parts_city[0] ?? $branch->city;
            $province_name = $parts_province[0] ?? $branch->province;
            $sub_district_name = $parts_sub_district[0] ?? $branch->sub_district;
            $branch_code = "{$branch_id}-{$province_name}-{$city_name}-{$sub_district_name}";

            $branch->update(['branch_code' => $branch_code]);
            return redirect()->route('branches.index')->with('success', 'Branch update successfully');
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('branches.index')->with('error', 'Branch Failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        try{
            $branch->delete();
            return redirect()->route('branches.index')->with('success', 'branch deleted');
        }catch(Exception $e){
           return redirect()->route('branches.index')->with('error', 'Failed to delete branch');

        }
    }
}
