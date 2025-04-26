<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->input('search');
            if($search){
                $members = Member::where('member_name', 'like', '%' .$search. '%')->paginate(10);
            }else{
                $members = Member::paginate(10);
            }
            return view('members.members', compact('members'));

        }catch(Exception $e){
            Log::info($e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'member_name' => 'string|required',
                'phone_number' => 'string|min:10|required',
                // 'point' => 'integer|nullable'
            ]);

            Member::create($validated);
            return redirect()->route('members.index')->with('success', 'Member created successfully');
        }catch(Exception $e){
            dd($e);
            return redirect()->route('members.index')->with('error', 'Member failed to create');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $bills = Bill::where('members_id', $member->id)->latest()->get();
        $result = DB::select("SELECT total_bills_by_member(?) AS total_bills", [$member->id]);
        $total_bills = $result[0]->total_bills ?? 0;

        foreach($bills as $bill){
            $bill->load(['member', 'branch', 'users', 'payment']);
        }
        return view('members.update', compact(['member', 'bills', 'total_bills']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        try{
            $validated = $request->validate([
                'member_name' => 'string|required',
                'phone_number' => 'string|min:10|required',
                // 'point' => 'integer|nullable'
            ]);

            $member->update($validated);
            return redirect()->route('members.index')->with('success', 'Member update successfully');
        }catch(Exception $e){
            dd($e);
            return redirect()->route('members.index')->with('error', 'Member failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        try{
            $member->delete();
            return redirect()->route('members.index')->with('success', 'member deleted');
        }catch(Exception $e){
           return redirect()->route('members.index')->with('error', 'Failed to delete member');

        }
    }
}
