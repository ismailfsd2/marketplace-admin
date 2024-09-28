@extends('auth.layout')
@section('body')
    <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card mt-4">
            <div class="card-body p-4">
                <div class="text-center mt-2">
                    <h5 class="text-primary">Welcome Back !</h5>
                    <p class="text-muted">Sign in to continue to Velzon.</p>
                </div>
                <div class="p-2 mt-4">
                    <form action="{{ route('auth.login') }}" id="auth-login" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                        </div>
                        <div class="mb-3">
                            <div class="float-end">
                                <a href="{{ route('auth.forget_password') }}" class="text-muted">Forgot password?</a>
                            </div>
                            <label class="form-label" for="password-input">Password</label>
                            <div class="position-relative auth-pass-inputgroup mb-3">
                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input" name="password">
                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer')
<script>
    $.ajaxForm('#auth-login');
</script>
@stop
