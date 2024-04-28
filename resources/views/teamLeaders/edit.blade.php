@extends('layouts.app')

@section('title', 'تعديل المسئول')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">تعديل المسئول</h1>
            <a href="{{route('teamLeaders.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">رجوع <i
                    class="fas fa-arrow-left fa-sm text-white-50"></i></a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4 text-right">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">تعديل المسئول</h6>
            </div>
            <form method="POST" action="{{route('teamLeaders.update', ['teamLeader' => $teamLeader->id])}}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">


                        <input
                            type="hidden"
                            class="form-control form-control-user"
                            id="teamLeader_id"
                            name="teamLeader_id"
                            value="{{$teamLeader->id}}">


                        {{-- tl_name --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <label>اسم المستخدم ثلاثي <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('tl_name') is-invalid @enderror"
                                id="tl_name"
                                name="tl_name"
                                value="{{ $teamLeader->tl_name }}">

                            @error('tl_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- tl_team_name --}}
                        {{-- <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>اسم الفريق <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('tl_team_name') is-invalid @enderror"
                                id="tl_team_name"
                                name="tl_team_name"
                                value="{{ $teamLeader->tl_team_name }}">

                            @error('tl_team_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div> --}}

                        {{-- tl_phone_NO1 --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم الهاتف الأول <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('tl_phone_NO1') is-invalid @enderror"
                                id="tl_phone_NO1"
                                name="tl_phone_NO1"
                                value="{{ $teamLeader->tl_phone_NO1 }}">

                            @error('tl_phone_NO1')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- tl_phone_NO2 --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم الهاتف الثاني </label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('tl_phone_NO2') is-invalid @enderror"
                                id="tl_phone_NO2"
                                name="tl_phone_NO2"
                                value="{{ $teamLeader->tl_phone_NO2 }}">

                            @error('tl_phone_NO2')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- address --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <label>عنوان السكن <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('address') is-invalid @enderror"
                                id="address"
                                name="address"
                                value="{{ $teamLeader->address }}">

                            @error('address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>



                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">تعديل</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('teamLeaders.index') }}">إلغاء</a>
                </div>
            </form>
        </div>

    </div>

@endsection
