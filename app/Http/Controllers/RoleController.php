<?php

namespace App\Http\Controllers;

// use App\Role;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        $permissions = Permission::get();

        return view('roles.index',
            array(
                'roles' => $roles,
                'permissions' => $permissions
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
        $this->validate($request, [
            // 'code' => 'required|max:10|unique:buildings,code',
            'name' => 'required'
        ]);

        $role = new Role;
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

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
        $role = Role::findOrFail($id);
        $permissions = Permission::get();

        return view('roles.show',
            array(
                'role' => $role,
                'permissions' => $permissions
            )
        );
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
        $this->validate($request, [
            // 'code' => 'required|max:10|unique:buildings,code',
            'name' => 'required'
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

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

    public function storePermission(Request $request)
    {
        $this->validate($request, [
            // 'code' => 'required|max:10|unique:buildings,code',
            'name' => 'required'
        ]);

        $permission = new Permission;
        $permission->name = $request->name;
        $permission->guard_name = 'web';
        $permission->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    public function storeRolePermission(Request $request)
    {
        // dd($request->all());
        $role = Role::findByName($request->role);
        $role->syncPermissions($request->permission);

        toastr()->success('Successfully Saved');
        return back();
    }

    public function updatePermission(Request $request,$id)
    {
        $this->validate($request, [
            // 'code' => 'required|max:10|unique:buildings,code',
            'name' => 'required'
        ]);

        $role = Permission::findOrFail($id);
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();

        toastr()->success('Successfully Updated');
        return back();
    }
}
