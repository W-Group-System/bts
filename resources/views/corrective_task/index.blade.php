@extends('layouts.header')

@section('css')
<!-- Dragula -->
<link rel="stylesheet" href="{{ asset('assets/libs/dragula/dragula.min.css') }}">
<link rel="stylesheet" href="{{ asset('toast/jquery.toast.min.css') }}">
@endsection

@section('content')
<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">Corrective Task</h1>
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
    <div class="col-md-12">
        <div class="card custom-card">
            {{-- <div class="card-header">
                <h6 class="card-title">Corrective</h6>
            </div> --}}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-nowrap" id="datatable-basic" style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">Action</th>
                                <th scope="col">Task ID</th>
                                <th scope="col">Last Updated</th>
                                <th scope="col">From</th>
                                <th scope="col">Priority</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Status</th>
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
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">{{ $c->series_number }}</td>
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">{{ date('M d Y h:i A', strtotime($c->updated_at)) }}</td>
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">{{ $c->createdBy->name }}</td>
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">
                                        @if($c->priority == "High")
                                        <span class="badge bg-danger">{{ $c->priority }}</span>
                                        @elseif($c->priority == "Medium")
                                        <span class="badge bg-warning">{{ $c->priority }}</span>
                                        @elseif($c->priority == "Low")
                                        <span class="badge bg-info">{{ $c->priority }}</span>
                                        @endif
                                    </td>
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">{{ $c->assignTo ? $c->assignTo->name : 'No assign yet' }}</td>
                                    <td class="@if($c->status == "Todo") fw-bold @else fw-normal @endif">{{ $c->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End::row-2 -->

{{-- @include('corrective_board.newBoard') --}}
@endsection

@section('js')

@endsection