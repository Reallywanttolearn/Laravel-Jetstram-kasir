@extends('layouts.auth')

@section('login')
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="h1">
                    <img src="{{ asset('images/logo-login.png') }}" alt="logo-kashir" width="200" height="200"
                        class="my-3">
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Login Admin</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3 ">
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid  @enderror" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" id="email"
                            class="form-control @error('password') is-invalid  @enderror" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Please provide a valid email.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember" class="h6">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
@endsection
