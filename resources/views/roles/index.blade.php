@extends('layouts.header')

@section('content')
<div class="row mt-3">
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Roles</p>
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
                        <p class="mb-0 text-muted">Total Permissions</p>
                        <div class="d-flex align-items-center">
                            <span class="fs-5 fw-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Inactive Roles</p>
                        <div class="d-flex align-items-center">
                            <span class="fs-5 fw-semibold">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-header">
                    <h5 class="mb-0 fs-5 fw-semibold">Roles</h5>
                    <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#new">
                        <i class="bi bi-plus-lg"></i>
                        Add roles
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100 table-sm" id="datatable-basic">
                            <thead>
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>
                                            <a href="{{ url('/roles/show/'.$role->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit{{ $role->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            {{--
                                            
                                            @if($role->status == "Active")
                                            <form method="POST" action="{{ url('/role/deactivate/'.$role->id) }}" class="d-inline-block">
                                                @csrf   
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form method="POST" action="{{ url('/role/activate/'.$role->id) }}" class="d-inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i>
                                                </button>
                                            </form>
                                            @endif --}}
                                        </td>
                                        <td>{{ $role->name }}</td>
                                    </tr>
    
                                    @include('roles.edit')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="card custom-card">
                <div class="card-header">
                    <h5 class="mb-0 fs-5 fw-semibold">Permissions</h5>
                    <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#newPermission">
                        <i class="bi bi-plus-lg"></i>
                        Add permissions
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover w-100 table-sm datatable-basic">
                            <thead>
                                <tr>
                                    <td>Action</td>
                                    <td>Name</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPermission{{ $permission->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                    </tr>

                                    @include('roles.edit_permission')
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('roles.new')
@include('roles.new_permission')
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('.datatable-basic').DataTable({
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            },
            "pageLength": 10,
            scrollX: true
        });
    })
</script>
@endsection