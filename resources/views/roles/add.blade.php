@extends('layouts.app')

@section('title', 'اضافة وظيفة')

@section('content')

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">اضافة وظيفة</h1>
        <a href="{{route('roles.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">رجوع <i
                class="fas fa-arrow-left fa-sm text-white-50"></i></a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-right">اضافة وظيفة جديدة</h6>
        </div>
        <div class="card-body text-right">
            <form method="POST" action="{{route('roles.store')}}">
                @csrf
                <div class="form-group row">

                    {{-- Name --}}
                    <div class="col-sm-6 mb-3 mb-sm-0 ">
                        <label>اسم الوظيفة <span style="color:red;">*</span></label>
                        <input
                            type="text"
                            class="form-control form-control-user @error('name') is-invalid @enderror"
                            id="exampleName"
                            name="name"
                            value="{{ old('name') }}">

                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>


                    {{-- Email --}}
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>النوع <span style="color:red;">*</span></label>
                        <select class="form-control form-control-user @error('guard_name') is-invalid @enderror" name="guard_name">
                            <option selected disabled>اختار النوع</option>
                            <option value="web" selected>Web</option>
                            <option value="api">Api</option>
                        </select>
                        @error('guard_name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>

                {{-- Save Button --}}
                <button type="submit" class="btn btn-success btn-user btn-block">
                    اضافة
                </button>

            </form>
        </div>
    </div>

</div>


@endsection
