@extends('layouts.header')

@section('css')
<!-- Dragula -->
<link rel="stylesheet" href="{{ asset('assets/libs/dragula/dragula.min.css') }}">
@endsection

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Corrective Board</h1>
    {{-- <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Task</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kanban Board</li>
            </ol>
        </nav>
    </div> --}}
</div>
<!-- Page Header Close -->

<!-- Start:: row-1 -->
{{-- <div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="row w-25">
                        <div class="col-xl-5">
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#add-board"><i
                                    class="ri-add-line me-1 fw-semibold align-middle"></i>New Board</button>
                        </div>
                        <div class="col-xl-7">
                            <select class="form-control kanban-sortby" data-trigger name="choices-single-default"
                                id="choices-single-default">
                                <option value="">Sort By</option>
                                <option value="Newest">Newest</option>
                                <option value="Date Added">Date Added</option>
                                <option value="Type">Type</option>
                                <option value="A - Z">A - Z</option>
                            </select>
                        </div>
                    </div>
                    <div class="avatar-list-stacked">
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/2.jpg" alt="img">
                        </span>
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/8.jpg" alt="img">
                        </span>
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/2.jpg" alt="img">
                        </span>
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/10.jpg" alt="img">
                        </span>
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/4.jpg" alt="img">
                        </span>
                        <span class="avatar avatar-rounded">
                            <img src="../assets/images/faces/13.jpg" alt="img">
                        </span>
                        <a class="avatar bg-primary avatar-rounded text-fixed-white" href="javascript:void(0);">
                            +8
                        </a>
                    </div>
                    <div class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-light" type="submit">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End:: row-1 -->

<!-- Start::row-2 -->
<div class="ynex-kanban-board">
    @foreach ($corrective_board as $board)
    <div class="kanban-tasks-type {{ $board->name }}">
        <div class="pe-3 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="d-block fw-semibold fs-15">{{ strtoupper($board->name) }} - {{
                    count(($board->corrective)->where('corrective_board_id',
                    $board->id)->where('status','!=','Cancelled')) }}</span>
                <div>
                    <a aria-label="anchor" href="javascript:void(0)"
                        class="btn btn-sm bg-white text-default border-0 btn-wave" data-bs-toggle="modal"
                        data-bs-target="#add-task">
                        <i class="ri-add-line align-middle me-1 fw-semibold"></i>Add Task
                    </a>
                </div>
            </div>
        </div>
        <div class="kanban-tasks" id="{{ $board->name }}-tasks" >
            <div id="{{ $board->name }}-tasks-draggable" data-view-btn="{{ $board->name }}-tasks" data-status="{{ $board->name }}">
                @foreach ($board->corrective->where('status','!=','Cancelled') as $corrective)
                <div class="card custom-card" data-id="{{ $corrective->id }}">
                    <div class="card-body p-0">
                        <div class="p-3 kanban-board-head">
                            <div class="d-flex text-muted justify-content-between mb-1 fs-12 fw-semibold">
                                <div><i class="ri-time-line me-1 align-middle"></i>Created - {{ date('d M',
                                    strtotime($corrective->created_at)) }}</div>
                                @php
                                $due_date = strtotime($corrective->due_date);
                                $created = strtotime($corrective->created_at);
                                $days_left = ($due_date-$created)/86400;
                                @endphp
                                @if($days_left > 0)
                                <div>{{ number_format($days_left) }} days left</div>
                                @else
                                <p class="badge bg-danger">Delayed</p>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="task-badges"><span class="badge bg-light text-default">#{{
                                        $corrective->building->code."-".str_pad($corrective->id,3,"0",STR_PAD_LEFT)
                                        }}</span><span class="ms-1 badge bg-primary-transparent">{{
                                        $corrective->priority }}</span></div>
                                <div class="dropdown">
                                    <a aria-label="anchor" href="javascript:void(0);"
                                        class="btn btn-icon btn-sm btn-light" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fe fe-more-vertical"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ url('/corrective/show/'.$corrective->id) }}"><i
                                                    class="ri-eye-line me-1 align-middle d-inline-block"></i>View</a>
                                        </li>
                                        {{-- <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-delete-bin-line me-1 align-middle d-inline-block"></i>Delete</a>
                                        </li> --}}
                                        {{-- <li><a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="ri-edit-line me-1 align-middle d-inline-block"></i>Edit</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                            <div class="kanban-content mt-2">
                                <h6 class="fw-semibold mb-1 fs-15">{{ $corrective->title }}</h6>
                                {{-- <div class="kanban-task-description">Lorem ipsum dolor sit amet consectetur
                                    adipisicing
                                    elit, Nulla soluta consectetur sit amet elit dolor sit amet.</div> --}}
                            </div>
                        </div>
                        <div class="p-3 border-top border-block-start-dashed">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    {{-- <a href="javascript:void(0);" class="me-2 text-primary">
                                        <span class="me-1"><i
                                                class="ri-thumb-up-fill align-middle fw-normal"></i></span><span
                                            class="fw-semibold fs-12">12</span>
                                    </a> --}}
                                    <a href="javascript:void(0);" class="text-muted">
                                        <span class="me-1"><i
                                                class="ri-message-2-line align-middle fw-normal"></i></span><span
                                            class="fw-semibold fs-12">0</span>
                                    </a>
                                </div>
                                <div class="avatar-list-stacked">
                                    <span class="avatar avatar-sm avatar-rounded">
                                        <img src="{{ asset('image/user.png') }}" alt="img">
                                    </span>
                                    {{-- <span class="avatar avatar-sm avatar-rounded">
                                        <img src="../assets/images/faces/12.jpg" alt="img">
                                    </span>
                                    <span class="avatar avatar-sm avatar-rounded">
                                        <img src="../assets/images/faces/7.jpg" alt="img">
                                    </span>
                                    <span class="avatar avatar-sm avatar-rounded">
                                        <img src="../assets/images/faces/8.jpg" alt="img">
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="d-grid view-more-button mt-3">
            <button class="btn btn-primary-light btn-wave">View More</button>
        </div>
    </div>
    @endforeach
</div>
<!--End::row-2 -->

@include('corrective_board.newBoard')
@endsection

@section('js')
<!-- Dragula JS -->
<script src="{{ asset('assets/libs/dragula/dragula.min.js') }}"></script>
<!-- Internal Task  JS -->
{{-- <script src="{{ asset('assets/js/task-kanban-board.js') }}"></script> --}}
<script>
    const drake = dragula([document.querySelector('#todo-tasks-draggable'), document.querySelector('#inprogress-tasks-draggable'), document.querySelector('#inreview-tasks-draggable'), document.querySelector('#completed-tasks-draggable')]);
    
    drake.on('drop', function(el, target, source, sibling) {
        const status = target.getAttribute('data-status')
        const dataId = el.getAttribute('data-id')
        
        $.ajax({
            type:"POST",
            url:"{{ url('corrective/update-status') }}",
            data: {
                _token:"{{ csrf_token() }}",
                status: status,
                id: dataId
            },
            success:function(res){
                location.reload()
            }
        })
    })

    // var myElement1 = document.getElementById('new-tasks');
    // new SimpleBar(myElement1, { autoHide: true });

    var myElement2 = document.getElementById('todo-tasks');
    new SimpleBar(myElement2, { autoHide: true });

    var myElement3 = document.getElementById('inprogress-tasks');
    new SimpleBar(myElement3, { autoHide: true });

    var myElement4 = document.getElementById('inreview-tasks');
    new SimpleBar(myElement4, { autoHide: true });

    var myElement5 = document.getElementById('completed-tasks');
    new SimpleBar(myElement5, { autoHide: true });


    document.addEventListener("DOMContentLoaded", () => {
        setInterval(() => {
            let i = [
                // document.querySelector('#new-tasks-draggable'),
                document.querySelector('#todo-tasks-draggable'),
                document.querySelector('#inprogress-tasks-draggable'),
                document.querySelector('#inreview-tasks-draggable'),
                document.querySelector('#completed-tasks-draggable')
            ]
            i.map((ele) => {
                if (ele) {
                    if (ele.children.length == 0) {
                        ele.classList.add("task-Null")
                        document.querySelector(`#${ele.getAttribute("data-view-btn")}`).nextElementSibling.classList.add("d-none")
                    }
                    if (ele.children.length != 0) {
                        ele.classList.remove("task-Null")
                        document.querySelector(`#${ele.getAttribute("data-view-btn")}`).nextElementSibling.classList.remove("d-none")
                    }
                }
            })
        }, 100);
    })
</script>
@endsection