@extends('layouts.header')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/libs/filepond/filepond.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
<style>
    textarea.is-invalid + .note-editor .note-editing-area
    {
        border: 1px solid red;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Corrective</h1>
    {{-- <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="#">Task</a></li>
                <li class="breadcrumb-item active" aria-current="page">Task List</li>
            </ol>
        </nav>
    </div> --}}
</div>
<!-- Page Header Close -->

<!-- Start::row-1 -->
<div class="row">
    <div class="col-xl-9">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Total Tasks
                </div>
                <div class="d-flex">
                    <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal"
                        data-bs-target="#create-task"><i class="ri-add-line fw-semibold align-middle me-1"></i> Create
                        Task</button>
                    @include('corrective.newTask')
                    <div class="dropdown ms-2">
                        <button class="btn btn-icon btn-secondary-light btn-sm btn-wave waves-light" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">New Tasks</a></li>
                            <li><a class="dropdown-item" href="#">Pending Tasks</a></li>
                            <li><a class="dropdown-item" href="#">Completed Tasks</a></li>
                            <li><a class="dropdown-item" href="#">Inprogress Tasks</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered table-sm" id="datatable-basic" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Task ID</th>
                                <th scope="col">Task</th>
                                <th scope="col">Assigned Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Ticket By</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($corrective as $c)
                                <tr class="task-list">
                                    <td>
                                        @php
                                            $building = $c->building->code;
                                        @endphp
                                        <span class="fw-semibold">{{ $building.'-'.str_pad($c->id,3,"0",STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $c->title }}</span>
                                    </td>
                                    <td>
                                        @if($c->date_assign)
                                        <span class="fw-semibold">{{ date('M d Y', strtotime($c->date_assign)) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($c->status == "New")
                                        <span class="fw-semibold text-primary">New</span>
                                        @elseif($c->status == "Pending")
                                        <span class="fw-semibold text-warning">Pending</span>
                                        @elseif($c->status == "For checking")
                                        <span class="fw-semibold text-info">For checking</span>
                                        @elseif($c->status == "Done")
                                        <span class="fw-semibold text-success">Done</span>
                                        @elseif($c->status == "Cancelled")
                                        <span class="fw-semibold text-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ date('M d Y', strtotime($c->due_date)) }}</span>
                                    </td>
                                    <td>
                                        @if($c->priority == "Low")
                                        <span class="badge bg-success-transparent">Low</span>
                                        @elseif($c->priority == "Medium")
                                        <span class="badge bg-warning-transparent">Medium</span>
                                        @elseif($c->priority == "High")
                                        <span class="badge bg-danger-transparent">High</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{-- <div class="avatar-list-stacked">
                                            <span class="avatar avatar-sm avatar-rounded">
                                                <img src="../assets/images/faces/2.jpg" alt="img">
                                            </span>
                                            <span class="avatar avatar-sm avatar-rounded">
                                                <img src="../assets/images/faces/8.jpg" alt="img">
                                            </span>
                                            <span class="avatar avatar-sm avatar-rounded">
                                                <img src="../assets/images/faces/2.jpg" alt="img">
                                            </span>
                                            <a class="avatar avatar-sm bg-primary avatar-rounded text-fixed-white"
                                                href="javascript:void(0);">
                                                +2
                                            </a>
                                        </div> --}}
                                        @if($c->assignTo)
                                            {{ $c->assignTo->name }}
                                        @endif
                                    </td>
                                    <td>
                                        {{ $c->createdBy->name }}
                                    </td>
                                    <td>
                                        @if($c->status == "New")
                                        <button class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#edit-task{{ $c->id }}">
                                            <i class="ri-edit-line"></i>
                                        </button>


                                        <form method="POST" action="{{ url('/corrective/cancel/'.$c->id) }}" class="d-inline-block">
                                            @csrf

                                            <button class="btn btn-danger-light btn-icon ms-1 btn-sm task-delete-btn" type="submit">
                                                <i class="ri-delete-bin-5-line"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>

                                @include('corrective.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3">
        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-primary-transparent me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 24 24"
                            class="svg-primary">
                            <path
                                d="M13,16H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2ZM9,10h2a1,1,0,0,0,0-2H9a1,1,0,0,0,0,2Zm12,2H18V3a1,1,0,0,0-.5-.87,1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0l-3,1.72-3-1.72a1,1,0,0,0-1,0A1,1,0,0,0,2,3V19a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V13A1,1,0,0,0,21,12ZM5,20a1,1,0,0,1-1-1V4.73L6,5.87a1.08,1.08,0,0,0,1,0l3-1.72,3,1.72a1.08,1.08,0,0,0,1,0l2-1.14V19a3,3,0,0,0,.18,1Zm15-1a1,1,0,0,1-2,0V14h2Zm-7-7H7a1,1,0,0,0,0,2h6a1,1,0,0,0,0-2Z" />
                        </svg>
                    </div>
                    <div class="flex-fill">
                        <h6 class="mb-2 fs-12">New Tasks
                            <span class="badge bg-primary fw-semibold float-end">
                                0
                            </span>
                        </h6>
                        <div class="pb-0 mt-0">
                            <div>
                                <h4 class="fs-18 fw-semibold mb-2"><span class="count-up" data-count="0">0</span><span
                                        class="text-muted float-end fs-11 fw-normal">Last Year</span></h4>
                                <p class="text-muted fs-11 mb-0 lh-1">
                                    <span class="text-success me-1 fw-semibold">
                                        <i class="ri-arrow-up-s-line me-1 align-middle"></i>0%
                                    </span>
                                    <span>this month</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-top">
                    <div class="svg-icon-background bg-success-transparent me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="svg-success">
                            <path
                                d="M11.5,20h-6a1,1,0,0,1-1-1V5a1,1,0,0,1,1-1h5V7a3,3,0,0,0,3,3h3v5a1,1,0,0,0,2,0V9s0,0,0-.06a1.31,1.31,0,0,0-.06-.27l0-.09a1.07,1.07,0,0,0-.19-.28h0l-6-6h0a1.07,1.07,0,0,0-.28-.19.29.29,0,0,0-.1,0A1.1,1.1,0,0,0,11.56,2H5.5a3,3,0,0,0-3,3V19a3,3,0,0,0,3,3h6a1,1,0,0,0,0-2Zm1-14.59L15.09,8H13.5a1,1,0,0,1-1-1ZM7.5,14h6a1,1,0,0,0,0-2h-6a1,1,0,0,0,0,2Zm4,2h-4a1,1,0,0,0,0,2h4a1,1,0,0,0,0-2Zm-4-6h1a1,1,0,0,0,0-2h-1a1,1,0,0,0,0,2Zm13.71,6.29a1,1,0,0,0-1.42,0l-3.29,3.3-1.29-1.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0l4-4A1,1,0,0,0,21.21,16.29Z" />
                        </svg>
                    </div>
                    <div class="flex-fill">
                        <h6 class="mb-2 fs-12">Completed Tasks
                            <span class="badge bg-success fw-semibold float-end">
                                0
                            </span>
                        </h6>
                        <div>
                            <h4 class="fs-18 fw-semibold mb-2"><span class="count-up" data-count="0">0</span><span
                                    class="text-muted float-end fs-11 fw-normal">Last Year</span></h4>
                            <p class="text-muted fs-11 mb-0 lh-1">
                                <span class="text-danger me-1 fw-semibold">
                                    <i class="ri-arrow-down-s-line me-1 align-middle"></i>0%
                                </span>
                                <span>this month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-warning-transparent me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"
                            class="svg-warning">
                            <path
                                d="M19,12h-7V5c0-0.6-0.4-1-1-1c-5,0-9,4-9,9s4,9,9,9s9-4,9-9C20,12.4,19.6,12,19,12z M12,19.9c-3.8,0.6-7.4-2.1-7.9-5.9C3.5,10.2,6.2,6.6,10,6.1V13c0,0.6,0.4,1,1,1h6.9C17.5,17.1,15.1,19.5,12,19.9z M15,2c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h6c0.6,0,1-0.4,1-1C22,5.1,18.9,2,15,2z M16,8V4.1C18,4.5,19.5,6,19.9,8H16z" />
                        </svg>
                    </div>
                    <div class="flex-fill">
                        <h6 class="mb-2 fs-12">Pending Tasks
                            <span class="badge bg-warning fw-semibold float-end">
                                0
                            </span>
                        </h6>
                        <div>
                            <h4 class="fs-18 fw-semibold mb-2"><span class="count-up" data-count="0">0</span><span
                                    class="text-muted float-end fs-11 fw-normal">Last Year</span></h4>
                            <p class="text-muted fs-11 mb-0 lh-1">
                                <span class="text-success me-1 fw-semibold">
                                    <i class="ri-arrow-up-s-line me-1 align-middle"></i>0%
                                </span>
                                <span>this month</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-top p-4 border-bottom border-block-end-dashed">
                    <div class="svg-icon-background bg-secondary-transparent me-4">
                        <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"
                            class="svg-secondary">
                            <path
                                d="M19,12h-7V5c0-0.6-0.4-1-1-1c-5,0-9,4-9,9s4,9,9,9s9-4,9-9C20,12.4,19.6,12,19,12z M12,19.9c-3.8,0.6-7.4-2.1-7.9-5.9C3.5,10.2,6.2,6.6,10,6.1V13c0,0.6,0.4,1,1,1h6.9C17.5,17.1,15.1,19.5,12,19.9z M15,2c-0.6,0-1,0.4-1,1v6c0,0.6,0.4,1,1,1h6c0.6,0,1-0.4,1-1C22,5.1,18.9,2,15,2z M16,8V4.1C18,4.5,19.5,6,19.9,8H16z" />
                        </svg>
                    </div>
                    <div class="flex-fill">
                        <h6 class="mb-2 fs-12">Inprogress Tasks
                            <span class="badge bg-secondary fw-semibold float-end">
                                0
                            </span>
                        </h6>
                        <div>
                            <h4 class="fs-18 fw-semibold mb-2"><span class="count-up" data-count="0">0</span><span
                                    class="text-muted float-end fs-11 fw-normal">Last Year</span></h4>
                            <p class="text-muted fs-11 mb-0 lh-1">
                                <span class="text-success me-1 fw-semibFold">
                                    <i class="ri-arrow-down-s-line me-1 align-middle"></i>0%
                                </span>
                                <span>this month</span>
                            </p>
                        </div>
                    </div>
                </div>
                {{-- <div class="p-4 pb-2">
                    <p class="fs-15 fw-semibold">Tasks Statistics <span class="text-muted fw-normal">(Last 6 months)
                            :</span></p>
                    <div id="task-list-stats"></div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
<script src="{{ asset('assets/libs/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
<script src="{{ asset('assets/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 300,
            placeholder: "Write task..."
        });

        const MultipleElement = document.querySelector('.blog-images');
        FilePond.create(MultipleElement, {
            storeAsFile: true
        });
    });
</script>
@endsection