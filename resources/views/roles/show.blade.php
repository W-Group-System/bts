@extends('layouts.header')

@section('content')
<div class="row mt-3">
    <div class="col-md-4">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="m-0 text-muted font-semibold">View role details</h6>
            </div>
            <div class="card-body">
                Name : {{ $role->name }}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card custom-card">
            <div class="card-header">
                <h6 class="m-0 text-muted font-semibold">View permission</h6>
            </div>
            <form method="POST" action="{{ url('/roles/store-role-permission') }}">
                @csrf

                <input type="hidden" name="role" value="{{ $role->name }}">

                <div class="card-body">
                    {{-- @dd($role->permissions) --}}
                    @php
                        $permissions_array = $role->permissions->pluck('name')->toArray();
                    @endphp
                    @if(count($role->permissions) > 0)
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" name="permission[]" value="{{ $permission->name }}" type="checkbox" id="{{ $permission->id }}" @if(in_array($permission->name, $permissions_array)) checked @endif>
                                <label class="form-check-label" for="{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    @else
                        @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input class="form-check-input" name="permission[]" value="{{ $permission->name }}" type="checkbox" id="{{ $permission->id }}" >
                                <label class="form-check-label" for="{{ $permission->id }}">
                                    {{ $permission->name }}
                                </label>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save permission</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection