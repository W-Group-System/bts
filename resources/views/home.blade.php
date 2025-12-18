@extends('layouts.header')

@section('content')
<!-- Start::page-header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div>
        <p class="fw-semibold fs-18 mb-0">Welcome back, {{ auth()->user()->name }} !</p>
        {{-- <span class="fs-semibold text-muted">Track your sales activity, leads and deals here.</span> --}}
    </div>
</div>
<!-- End::page-header -->
@endsection