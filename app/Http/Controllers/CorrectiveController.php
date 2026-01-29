<?php

namespace App\Http\Controllers;

use App\Approver;
use App\Building;
use App\Category;
use App\Comment;
use App\Corrective;
use App\CorrectiveAttachment;
use App\CorrectiveBoard;
use App\CorrectiveBoardAccess;
use App\Role;
use App\User;
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
        $corrective = Corrective::with('assignTo','building','createdBy','category')->get();
        // $buildings = Building::where('status','Active')->get();
        // $categories = Category::with('subcategory')->where('status','Active')->get();
        
        return view('corrective.index',
            array(
                'corrective' => $corrective,
                // 'buildings' => $buildings,
                // 'categories' => $categories
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
        $buildings = Building::where('status','Active')->get();
        $categories = Category::with('subcategory')->where('status','Active')->get();
        
        return view('corrective.newTask',
            array(
                'buildings' => $buildings,
                'categories' => $categories
            )
        );
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
            'type_of_issues' => 'required',
            'affected_locations' => 'required',
            'time_identified' => 'required',
            'task' => 'required',
            'priority' => 'required',
            'attachments' => 'required',
        ]);

        $corrective = Corrective::with('category')->where('building_id', $request->affected_locations)
                                    ->orderBy('id','DESC')
                                    ->first();
        $building = Building::findOrFail($request->affected_locations);
        if(empty($corrective)) {
            $series_number = $building->code.'-'.date('Y').'-'.str_pad('1',5,'0',STR_PAD_LEFT);
        }
        else {
            $latestSeriesNumber = explode('-',$corrective->series_number);
            $nextNumber = (int)$latestSeriesNumber[2]+1;
            $series_number = $building->code.'-'.date('Y').'-'.str_pad($nextNumber,5,'0',STR_PAD_LEFT);
        }

        $corrective = new Corrective;
        $corrective->category_id = $request->type_of_issues;
        $corrective->subcategory_id = $request->subtype_issues;
        $corrective->description = $request->description;
        $corrective->series_number = $series_number;
        $corrective->building_id = $request->affected_locations;
        if($request->quantity) {
            $corrective->quantity = $request->quantity;
        }
        $corrective->time_identified = $request->time_identified;
        $corrective->priority = $request->priority;
        $corrective->task = $request->task;
        $corrective->created_by = auth()->user()->id;
        $corrective->status = "Todo";
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
        return redirect('/corrective');
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
        $corrective = Corrective::with('building','createdBy','assignTo','assignBy','correctiveAttachment','comment', 'approvers.user')->findOrFail($id);
        $users = User::where('status','Active')->get();
        $roles = Role::get();

        return view('corrective.details',
            array(
                'corrective' => $corrective,
                'users' => $users,
                'roles' => $roles
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
        // $this->validate($request,[
        //     'viber_number' => 'max:11|required',
        //     'title' => 'required',
        //     'due_date' => 'required',
        //     'priority' => 'required|in:Low,Medium,High',
        //     'task' => 'required'
        // ]);

        // $corrective = Corrective::findOrFail($id);
        // $corrective->viber_number = $request->viber_number;
        // $corrective->title = $request->title;
        // $corrective->due_date = $request->due_date;
        // $corrective->priority = $request->priority;
        // $corrective->task = $request->task;
        // $corrective->building_id = $request->building;
        // $corrective->save();

        // toastr()->success('Successfully Updated');
        // return back();
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

    public function cancelled(Request $request, $id)
    {
        $corrective = Corrective::findOrFail($id);
        $corrective->status = "Cancelled";
        $corrective->cancel_remark = $request->remarks;
        $corrective->save();

        toastr()->success('Successfully Cancelled');
        return back();
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $this->validate($request,[
            'action' => 'required'
        ]);

        $corrective = Corrective::findOrFail($request->corrective_id);
        $corrective->status = $request->action;
        $corrective->save();

        $getBuildingAdmin = Building::with('user')->where('id', auth()->user()->building_id)->first();
        $requestor = $corrective->created_by;
        $approvers = [
            $getBuildingAdmin->user_id,
            $requestor
        ];
        
        if($request->action == "todo" || $request->action == "progress" || $request->action == "ba_return" || $request->action == "sqa_return")
        {
            $correctiveApprovers = Approver::where('corrective_id', $corrective->id)->get();
            if(count($correctiveApprovers) > 0)
            {
                foreach($correctiveApprovers as $key => $approver)
                {
                    $approver->status = "Waiting";
                    $approver->start_date = null;
                    $approver->save();
                }
            }
        }
        elseif ($request->action == "For Review")
        {
            $correctiveApprovers = Approver::where('corrective_id', $corrective->id)->get();
            if(count($correctiveApprovers) == 0)
            {
                foreach($approvers as $key => $approver)
                {
                    $btsApprover = new Approver;
                    $btsApprover->user_id = $approver;
                    $btsApprover->level = $key+1;
                    $btsApprover->corrective_id =  $corrective->id;
                    if($key == 0) 
                    {
                        $btsApprover->status = "Pending";
                        $btsApprover->start_date = date('Y-m-d');
                    }
                    else 
                    {
                        $btsApprover->status = "Waiting";
                    }
                    $btsApprover->save();
                }
            }
            else 
            {
                $correctiveApprovers = Approver::where('corrective_id', $corrective->id)->get();
                foreach($correctiveApprovers as $key => $approver)
                {
                    if($key == 0) 
                    {
                        $approver->status = "Pending";
                        $approver->start_date = date('Y-m-d');
                    }
                    else 
                    {
                        $approver->status = "Waiting";
                    }
                    $approver->save();
                }
            }
        }
        // elseif ($request->action == "verification" || $request->action == "done")
        // {
        //     $buildingAdminApprover = Approver::where('corrective_id', $corrective->id)->where('status','Pending')->first();
        //     $buildingAdminApprover->status = "Approved";
        //     $buildingAdminApprover->save();

        //     $correctiveApprovers = Approver::where('corrective_id', $corrective->id)->where('status','Waiting')->get();
        //     if(count($correctiveApprovers) > 0) 
        //     {
        //         foreach($correctiveApprovers as $key => $approver)
        //         {
        //             if($key == 0) 
        //             {
        //                 $approver->status = "Pending";
        //                 $approver->start_date = date('Y-m-d');
        //             }
        //             else 
        //             {
        //                 $approver->status = "Waiting";
        //             }
        //             $approver->save();
        //         }
        //     }
        //     else
        //     {
        //         $corrective->status = "Closed";
        //         $corrective->save();
        //     }
        // }

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

    public function assign(Request $request,$id)
    {
        // dd($request->all(),$id);
        $corrective = Corrective::findOrFail($id);
        $corrective->assign_to = $request->assignTo;
        $corrective->assign_by = auth()->user()->id;
        $corrective->date_assign = date('Y-m-d');
        $corrective->save();

        $user = User::findOrFail($request->assignTo);

        $comment = new Comment;
        $comment->comment = '<b>'.auth()->user()->name.'</b>'.' assign this to ' .'<b>'.$user->name.'</b>';
        $comment->corrective_id = $id;
        $comment->save();

        toastr()->success('Successfully Assigned');
        return back();
    }

    public function refreshCorrective(Request $request)
    {
        // dd($request->all());
        $category = Category::with('subcategory')->findOrFail($request->category);
        $haveQty = false;
        $options = "<option value=''></option>";
        $haveOptions = false;
        if ($category->have_qty == 1) {
            $haveQty = true;
        }

        if (count($category->subcategory) > 0) {
            $haveOptions = true;
            foreach($category->subcategory as $subcategory) {
                $options.= "<option value=".$subcategory->id.">".$subcategory->subcategory."</option>";
            }
        }

        return response()->json(['status'=>'success','data' => $haveQty, 'options' => $options, 'haveOptions' => $haveOptions]);
    }
}
