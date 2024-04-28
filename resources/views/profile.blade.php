@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
            <h1 class="h3 mb-0 text-gray-800">الملف الشخصي</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        {{-- Page Content --}}
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" width="150px" src="{{ asset('admin/img/undraw_profile.svg') }}">
                    <span class="font-weight-bold">{{ auth()->user()->full_name }}</span>
                    <span class="text-black-50"><i>Role:
                            {{ auth()->user()->roles
                                ? auth()->user()->roles->pluck('name')->first()
                                : 'N/A' }}</i></span>
                    <span class="text-black-50">{{ auth()->user()->email }}</span>
                </div>
            </div>
            <div class="col-md-9 border-right">
                {{-- Profile --}}
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">الملف الشخصي</h4>
                    </div>
                    <form action="{{ route('profile.update') }}" method="POST" class="text-right">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">الإسم الأول</label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    name="first_name" placeholder="First Name"
                                    value="{{ old('first_name') ? old('first_name') : auth()->user()->first_name }}">

                                @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">الإسم الأخير</label>
                                <input type="text" name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') ? old('last_name') : auth()->user()->last_name }}"
                                    placeholder="Last Name">

                                @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">رقم الجوال</label>
                                <input type="text" class="form-control @error('mobile_number') is-invalid @enderror" name="mobile_number"
                                    value="{{ old('mobile_number') ? old('mobile_number') : auth()->user()->mobile_number }}"
                                    placeholder="Mobile Number">
                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-primary profile-button" type="submit">تحديث البيانات</button>
                        </div>
                    </form>
                </div>

                <hr>
                {{-- Change Password --}}
                @hasrole('Admin')

                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">تغيير كلمة السر</h4>
                    </div>

                    <form action="{{ route('profile.change-password') }}" method="POST" class="text-right">
                        @csrf
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="labels">كلمة السر القديمة</label>
                                <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="كلمة السر القديمة" required>
                                @error('current_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">كلمة السر الجديدة</label>
                                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required placeholder="كلمة السر الجديدة">
                                @error('new_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="labels">تأكيد كلمة السر</label>
                                <input type="password" name="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" required placeholder="تأكيد كلمة السر">
                                @error('new_confirm_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-success profile-button" type="submit">تغيير كلمة السر</button>
                        </div>
                    </form>
                </div>
            </div>
            @endhasrole


        </div>



    </div>
@endsection
