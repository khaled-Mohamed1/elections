@extends('layouts.app')

@section('title', 'اضافة مركز الإقتراع')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">اضافة مركز الإقتراع</h1>
            <a href="{{route('electoralCenters.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">رجوع <i
                    class="fas fa-arrow-left fa-sm text-white-50"></i></a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4 text-right">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">اضافة مركز اقتراع جديد</h6>
            </div>
            <form method="POST" action="{{route('electoralCenters.store')}}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">

                        {{-- ec_name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>اسم مركز الإقتراع <span style="color:red;">*</span></label>
                            <input
                                style="height: 45px;"
                                type="text"
                                class="form-control form-control-user customer_qty @error('ec_name') is-invalid @enderror"
                                id="ec_name"
                                name="ec_name"
                                value="{{ old('ec_name') }}">

                            @error('ec_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- ec_NO --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم التسلسلي <span style="color:red;">*</span></label>
                            <input
                                style="height: 45px;"
                                type="text"
                                class="form-control form-control-user customer_qty @error('ec_NO') is-invalid @enderror"
                                id="ec_NO"
                                name="ec_NO"
                                value="{{ old('ec_NO') }}">

                            @error('ec_NO')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">اضافة</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('electoralCenters.index') }}">إلغاء</a>
                </div>
            </form>
        </div>

    </div>

@endsection
