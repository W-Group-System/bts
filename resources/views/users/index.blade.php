@extends('layouts.header')

@section('css')
<style>
    .choices {
        margin-bottom: 5px;
    }
    .choices:has(.is-invalid) {
        border: 1px solid red;
    }
</style>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-md-2">
        <div class="card custom-card">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-top justify-content-between">
                    <div class="flex-fill">
                        <p class="mb-0 text-muted">Total Users</p>
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
                        <p class="mb-0 text-muted">Total Active Users</p>
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
                        <p class="mb-0 text-muted">Total Inactive Users</p>
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
                <h5 class="mb-0 fs-5 fw-semibold">Users</h5>
                <button type="button" class="btn btn-sm btn-primary ms-auto" data-bs-toggle="modal"
                    data-bs-target="#new">
                    <i class="bi bi-plus-lg"></i>
                    Add users
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover w-100 table-sm" id="datatable-basic">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Building</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $user->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    @if($user->status == "Active")
                                    <form method="POST" action="{{ url('/users/deactivate/'.$user->id) }}"
                                        class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST" action="{{ url('/users/activate/'.$user->id) }}"
                                        class="d-inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                                <td>{{ $user->building->name }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleNames()->implode(', ') }}</td>
                                <td>
                                    @if($user->status == "Active")
                                    <span class="badge bg-success">
                                        @else
                                        <span class="badge bg-danger">
                                            @endif
                                            {{ $user->status }}
                                        </span>
                                </td>
                            </tr>

                            @include('users.edit')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('users.new')
@endsection

@section('js')
<script>
    const choicesConfig = {
        allowHTML: true,
        searchEnabled: true,
        removeItemButton: true
    };

    document.querySelectorAll('.choices-single').forEach(el => {
        new Choices(el, choicesConfig);
    });
</script>
@endsection