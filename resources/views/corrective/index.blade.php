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
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Task</p>
                        <div class="d-flex align-items-center">
                            <span class="fs-5 fw-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Cancelled Task</p>
                        <div class="d-flex align-items-center">
                            <span class="fs-5 fw-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Done Task</p>
                        <div class="d-flex align-items-center">
                            <span class="fs-5 fw-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Total Tasks
                </div>
                <div class="d-flex">
                    <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal"
                        data-bs-target="#create-task"><i class="ri-add-line fw-semibold align-middle me-1"></i> Create
                        Task</button>
                    {{-- <div class="dropdown ms-2">
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
                    </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered table-sm" id="datatable-basic" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col">Task ID</th>
                                <th scope="col">Task</th>
                                <th scope="col">Type of issues</th>
                                <th scope="col">Affected location</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Date & Time Identified</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Ticket By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($corrective as $c)
                                <tr>
                                    <td>
                                        <a href="{{ url('/corrective/show/'.$c->id) }}" class="btn btn-sm btn-info">
                                            <i class="ri ri-eye-line"></i>
                                            View details
                                        </a>
                                    </td>
                                    <td>{{ $c->series_number }}</td>
                                    <td>{!! $c->task !!}</td>
                                    <td>{{ $c->category->category }}</td>
                                    <td>{{ $c->building->name }}</td>
                                    <td>{{ $c->quantity }}</td>
                                    <td>{{ date('Y-m-d h:i A', strtotime($c->time_identified)) }}</td>
                                    <td>
                                        @if($c->priority == "High")
                                        <span class="badge bg-danger">{{ $c->priority }}</span>
                                        @elseif($c->priority == "Medium")
                                        <span class="badge bg-warning">{{ $c->priority }}</span>
                                        @elseif($c->priority == "Low")
                                        <span class="badge bg-info">{{ $c->priority }}</span>
                                        @endif
                                    </td>
                                    <td>{{ optional($c->assignTo)->name }}</td>
                                    <td>{{ $c->createdBy->name }}</td>
                                </tr>

                                {{-- @include('corrective.edit') --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End::row-1 -->
@include('corrective.newTask')
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

        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            })
        })

        $("#typeOfIssues").on('change', function() {
            const value = $(this).val()

            $.ajax({
                type:"POST",
                url:"{{ url('/corrective/refresh-corrective') }}",
                data: {
                    category: value,
                    _token:"{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    
                    if (response.data) {
                        $("#qtyColumn").prop('hidden', false)
                    }
                    else {
                        $("#qtyColumn").prop('hidden', true)
                    }

                    if (response.haveOptions) {
                        $("#subtypeContainer").prop('hidden', false)
                        $("#descriptionContainer").prop('hidden', false)

                        $("#subTypeIssues").html(response.options)
                    }
                    else {
                        $("#subtypeContainer").prop('hidden', true)
                        $("#descriptionContainer").prop('hidden', true)
                    }
                }
            })
        })
    });
</script>
@endsection