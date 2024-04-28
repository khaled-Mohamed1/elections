@extends('layouts.app')

@section('title', 'اضافة موظف')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">اضافة موظف</h1>
        <a href="{{route('users.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">رجوع <i
                class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4 text-right">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">اضافة موظف جديد</h6>
        </div>
        <form method="POST" action="{{route('users.store')}}">
            @csrf
            <div class="card-body">
                <div class="form-group row">

                    {{-- First Name --}}
                    <div class="col-sm-6 mb-3">
                        <label for="exampleFirstName">الإسم كامل <span style="color:red;">*</span></label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('first_name') is-invalid @enderror"
                            id="exampleFirstName"
                            name="first_name"
                            value="{{ old('first_name') }}">

                        @error('first_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Last Name --}}
                    <div class="col-sm-6 mb-3">
                        <label for="exampleLastName">الإسم الأخير <span style="color:red;">*</span></label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('last_name') is-invalid @enderror"
                            id="exampleLastName"
                            name="last_name"
                            value="{{ old('last_name') }}">

                        @error('last_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-sm-6 mb-3">
                        <label for="exampleEmail">البريد الإلكتروني <span style="color:red;">*</span></label>
                        <input
                            type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror"
                            id="exampleEmail"
                            name="email"
                            value="{{ old('email') }}">

                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Mobile Number --}}
                    <div class="col-sm-6 mb-3">
                        <label for="exampleMobile">رقم الجوال <span style="color:red;">*</span></label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('mobile_number') is-invalid @enderror"
                            id="exampleMobile"
                            name="mobile_number"
                            value="{{ old('mobile_number') }}">

                        @error('mobile_number')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Role --}}
                    <div class="col-sm-6 mb-3">
                        <label>الوظيفة <span style="color:red;">*</span></label>
                        <select class="form-control form-control-user @error('role_id') is-invalid @enderror" name="role_id">
                            <option selected disabled>اختار الوظيفة</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-sm-6 mb-3">
                        <label>الحالة <span style="color:red;">*</span></label>
                        <select class="form-control form-control-user @error('status') is-invalid @enderror" name="status">
                            <option selected disabled>اختار الحالة</option>
                            <option value="1" selected>مفعل</option>
                            <option value="0">غير مفعل</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-sm-6 mb-3">
                        <label for="password">كلمة السر <span style="color:red;">*</span></label>
                        <input
                            type="password"
                            class="form-control form-control-user @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            value="{{ old('password') }}">

                        @error('password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-success btn-user float-right mb-3">اضافة</button>
                <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('users.index') }}">إلغاء</a>
            </div>
        </form>
    </div>

</div>


@endsection
