<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildings = Building::get();

        return view('building.index',
            array(
                'buildings' => $buildings
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
            'code' => 'required|max:10|unique:buildings,code',
            'name' => 'required'
        ]);

        $building = new Building;
        $building->code = $request->code;
        $building->name = $request->name;
        $building->status = 'Active';
        $building->save();

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
        $this->validate($request, [
            'code' => 'required|max:10|unique:buildings,code,'.$id,
            'name' => 'required'
        ]);

        $building = Building::findOrFail($id);
        $building->code = $request->code;
        $building->name = $request->name;
        $building->save();

        toastr()->success('Successfully Updated');
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
        $building = Building::findOrFail($id);
        $building->status = 'Inactive';
        $building->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function activate($id)
    {
        $building = Building::findOrFail($id);
        $building->status = 'Active';
        $building->save();

        toastr()->success('Successfully Activated');
        return back();
    }
}
