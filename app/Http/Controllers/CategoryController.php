<?php

namespace App\Http\Controllers;

use App\Category;
use App\Issue;
use App\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('subcategory')->get();

        return view('categories.index', 
            array(
                'categories' => $categories
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
        $this->validate($request,[
            'category' => 'required'
        ]);

        $category = new Category;
        $category->category = $request->category;
        if($request->has('have_quantity'))
        {
            $category->have_qty = 1;
        }
        $category->status = 'Active';
        $category->save();

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
    
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request,[
            'category' => 'required'
        ]);

        $category = Category::findOrFail($id);
        $category->category = $request->category;
        if($request->has('have_quantity'))
        {
            $category->have_qty = 1;
        }
        else
        {
            $category->have_qty = null;
        }
        $category->save();

        
        Subcategory::where('category_id',$id)->delete();
        if ($request->has('subcategory'))
        {
            foreach($request->subcategory as $subcategory) 
            {
                $subCategory = new Subcategory;
                $subCategory->category_id = $id;
                $subCategory->subcategory = $subcategory;
                $subCategory->save();
            }
        }

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
}
