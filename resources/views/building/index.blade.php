@extends('layouts.header')

@section('content')
<div class="row mt-3">
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Buildings</p>
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
                        <p class="mb-0 text-muted">Total Active Buildings</p>
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
                        <p class="mb-0 text-muted">Total Inactive Buildings</p>
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
            <div class="card-header">
                <h5 class="mb-0 fs-5 fw-semibold">Buildings</h5>
                <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#new">
                    <i class="bi bi-plus-lg"></i>
                    Add building
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover w-100 table-sm" id="datatable-basic">
                        <thead>
                            <tr>
                                <td>Action</td>
                                <td>Code</td>
                                <td>Name</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($buildings as $building)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $building->id }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        
                                        @if($building->status == "Active")
                                        <form method="POST" action="{{ url('/building/deactivate/'.$building->id) }}" class="d-inline-block">
                                            @csrf   
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ url('/building/activate/'.$building->id) }}" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="bi bi-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                    <td>{{ $building->code }}</td>
                                    <td>{{ $building->name }}</td>
                                    <td>
                                        @if($building->status == "Active")
                                        <span class="badge bg-success">
                                        @else 
                                        <span class="badge bg-danger">
                                        @endif
                                            {{ $building->status }}
                                        </span>
                                    </td>
                                </tr>

                                @include('building.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('building.new')
@endsection