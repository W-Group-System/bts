<?php

namespace App\Http\Controllers;

use App\Building;
use App\Comment;
use App\Corrective;
use App\CorrectiveAttachment;
use App\CorrectiveBoard;
use Illuminate\Http\Request;

class CorrectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corrective = Corrective::with('assignTo','building','createdBy')->get();
        $buildings = Building::where('status','Active')->get();
        
        return view('corrective.index',
            array(
                'corrective' => $corrective,
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
        $this->validate($request,[
            'viber_number' => 'max:11|required',
            'title' => 'required',
            'due_date' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'task' => 'required',
            'attachments' => 'required'
        ]);

        $corrective = new Corrective;
        $corrective->viber_number = $request->viber_number;
        $corrective->title = $request->title;
        $corrective->due_date = $request->due_date;
        $corrective->priority = $request->priority;
        $corrective->task = $request->task;
        $corrective->created_by = auth()->user()->id;
        $corrective->status = "New";
        $corrective->building_id = $request->building;
        $corrective->corrective_board_id = 1;
        $corrective->save();

        $attachments = $request->file('attachments');
        foreach($attachments as $attachment)
        {
            $size = $attachment->getSize();

            $name = time()."_".$attachment->getClientOriginalName();
            $attachment->move(public_path('corrective_attachments'),$name);
            $file = "/corrective_attachments/".$name;

            $corrective_attachment = new CorrectiveAttachment;
            $corrective_attachment->corrective_id = $corrective->id;
            $corrective_attachment->attachment = $file;
            $corrective_attachment->name = $name;
            $corrective_attachment->size = $size;
            $corrective_attachment->save();
        }

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
        // dd($id);
        $corrective = Corrective::with('building','createdBy','assignTo','assignBy','correctiveBoard','correctiveAttachment','comment')->findOrFail($id);

        return view('corrective.details',
            array(
                'corrective' => $corrective
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
        $this->validate($request,[
            'viber_number' => 'max:11|required',
            'title' => 'required',
            'due_date' => 'required',
            'priority' => 'required|in:Low,Medium,High',
            'task' => 'required'
        ]);

        $corrective = Corrective::findOrFail($id);
        $corrective->viber_number = $request->viber_number;
        $corrective->title = $request->title;
        $corrective->due_date = $request->due_date;
        $corrective->priority = $request->priority;
        $corrective->task = $request->task;
        $corrective->building_id = $request->building;
        $corrective->save();

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

    public function cancelled($id)
    {
        $corrective = Corrective::findOrFail($id);
        $corrective->status = "Cancelled";
        $corrective->save();

        toastr()->success('Successfully Cancelled');
        return back();
    }

    public function updateStatus(Request $request)
    {
        $correctiveBoard = CorrectiveBoard::where('name', $request->status)->first();
        // dd($correctiveBoard);
        $corrective = Corrective::findOrFail($request->id);
        $corrective->corrective_board_id = $correctiveBoard->id;
        $corrective->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    public function comment(Request $request,$id)
    {
        // dd($request->all(),$id);
        $this->validate($request,[
            'comment' => 'required'
        ]);

        $comments = new Comment;
        $comments->comment = $request->comment;
        $comments->user_id = auth()->id();
        $comments->corrective_id = $id;
        $comments->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    public function attachComment(Request $request,$id)
    {
        // dd($request->all(),$id);
        $this->validate($request,[
            'attachments' => 'required'
        ]);

        $attachments = $request->file('attachments');
        foreach($attachments as $attachment)
        {
            $extension = $attachment->getClientOriginalExtension();
            $name = time()."_".$attachment->getClientOriginalName();
            $attachment->move(public_path('comment_attachments'),$name);
            $file_attachment = "/comment_attachments/".$name;

            $comments = new Comment;
            $comments->attachment = $file_attachment;
            $comments->user_id = auth()->id();
            $comments->corrective_id = $id;
            $comments->attachment_type = $extension;
            $comments->save();
        }

        toastr()->success('Successfully Saved');
        return back();
    }
}
