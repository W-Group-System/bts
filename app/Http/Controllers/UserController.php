<?php

namespace App\Http\Controllers;

use App\Building;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role','building')->get();

        $buildings = Building::where('status','Active')->get();
        $roles = Role::get();

        return view('users.index',
            array(
                'users' => $users,
                'buildings' => $buildings,
                'roles' => $roles
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'building' => 'required|exists:buildings,id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('abc123');
        $user->building_id = $request->building;
        $user->status = 'Active';
        // $user->role_id = $request->role;
        $user->syncRoles($request->role);
        $user->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|min:10',
            'email' => 'required|email|unique:users,email,'.$id,
            'building' => 'required|exists:buildings,id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->building_id = $request->building;
        $user->status = 'Active';
        // $user->role_id = $request->role;
        $user->syncRoles($request->role);
        $user->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Inactive';
        $user->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Active';
        $user->save();

        toastr()->success('Successfully Activated');
        return back();
    }
}
