@extends('layouts.app')

@section('content')
<div class="row authentication mx-0">
    <div class="col-xxl-7 col-xl-7 col-lg-12">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-xxl-6 col-xl-7 col-lg-7 col-md-7 col-sm-8 col-12">
                <div class="p-5">
                    <p class="h5 fw-semibold mb-2">Sign In</p>
                    <p class="mb-3 text-muted op-7 fw-normal mb-5">Please login to your account</p>

                    <form method="POST" action="{{ url('login') }}">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-xl-12 mt-0">
                                <label for="signin-username" class="form-label text-default">Email</label>
                                <input type="text" name="email" class="form-control form-control-lg" id="signin-username"
                                    placeholder="johndoe@gmail.com">
                            </div>
                            <div class="col-xl-12 mb-3">
                                <label for="signin-password" class="form-label text-default d-block">Password<a
                                        href="reset-password-cover.html" class="float-end text-danger">Forget password
                                        ?</a></label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control form-control-lg" id="signin-password"
                                        placeholder="*******">
                                    <button class="btn btn-light" type="button"
                                        onclick="createpassword('signin-password',this)" id="button-addon2"><i
                                            class="ri-eye-off-line align-middle"></i></button>
                                </div>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                            Remember password ?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button type="submit" class="btn btn-lg btn-primary">Sign In</button>
                            </div>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="fs-12 text-muted mt-4">Dont have an account? <a href="sign-up-cover.html"
                                class="text-primary">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-5 col-xl-5 col-lg-5 d-xl-block d-none px-0">
        <img src="{{ asset('image/wcc.jpg') }}" alt="" class="authentication-cover" style="height: 100vh;">
    </div>

</div>
@endsection