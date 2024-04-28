@extends('auth.layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
        .h-custom {
            height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
        .form-label {
            text-align: right;
        }
    </style>
    <section class="vh-100">
        <div class="container-fluid h-custom text-right">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                         class="img-fluid" alt="Sample image">
                </div>

                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="divider d-flex align-items-center my-4">
                            <p class="text-center fw-bold mx-3 mb-0">تسجيل الدخول</p>
                        </div>

                        <!-- Email input -->
                        <div class="form-outline mb-4">
                            <label class="form-label mt-2" for="form3Example3">البريد الإلكتروني</label>
                            <input type="email" id="form3Example3" class="form-control form-control-lg text-right @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ادخل بريدك الإلكتروني"/>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label mt-2" for="form3Example4">كلمة السر</label>
                            <input type="password" id="form3Example4" class="form-control form-control-lg text-right @error('password') is-invalid @enderror"
                                   name="password" required autocomplete="current-password" placeholder="ادخل كلمة السر" />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" class="btn btn-primary btn-lg btn-user btn-block">
                                تسجيل الدخول
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="text-center text-   -start py-4 px-4 px-xl-5 bg-primary">
            <div class="text-white mb-3 mb-md-0">
                حقوق النشر © 2023. جميع الحقوق محفوظة.
            </div>
        </div>
    </section>
@endsection
