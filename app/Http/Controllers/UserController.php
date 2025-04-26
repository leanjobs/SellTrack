<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\isNull;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $search = $request->input('search');
            if($search){
                $users = User::with('user_branch')->where('user_name', 'like', '%' .$search. '%')->paginate(10);
            }else{
                $users = User::with('user_branch')->latest()->paginate(10);
            }
            foreach ($users as $user) {
                $result = DB::select('CALL total_bills_by_user(?)', [$user->id]);
                $user->total_bills = $result[0]->total_transaksi ?? 0;
            }

            return view('users.users', compact('users'));

        }catch(Exception $e){
            Log::info($e->getMessage());
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::where('status', 'active')->get();
        return view('users.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            // dd($request);
            $validated = $request->validate([
                'user_name' => 'string|required',
                'email' => 'email|required',
                'password' => 'required|min:8',
                'phone_number' => 'required',
                'role' => 'required|in:admin,super_admin,staff',
                'position' => 'string|required',
                'status' => 'string|required|in:active,inactive',
                'branches_id' => 'required|exists:branches,id',
            ]);
            User::create($validated);
            return redirect()->route('users.index')->with('success', 'User created successfully');

        }catch(Exception $e){
            dd($e);
            return redirect()->route('users.index')->with('error', 'Failed to create User');

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // dd($user);
        $branches = Branch::where('status', 'active')->get();
        return view('users.update', compact(['user', 'branches']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try{
            // dd($request);
            $validated = $request->validate([
                'user_name' => 'string|required',
                'email' => 'email|required',
                'password' => 'nullable|min:8',
                'phone_number' => 'required',
                'role' => 'required|in:admin,super_admin,staff',
                'position' => 'string|required',
                'status' => 'string|required|in:active,inactive',
                'branches_id' => 'required|exists:branches,id',

            ]);

            if (empty($request->password)) {
                $validated['password'] = $user->password;
            }

            $user->update($validated);
            return redirect()->route('users.index')->with('success', 'User Update successfully');

        }catch(Exception $e){
            dd($e);
            return redirect()->route('users.index')->with('error', 'Failed to update User');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try{
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted');
        }catch(Exception $e){
           return redirect()->route('users.index')->with('error', 'Failed to delete user');

        }
    }
}
