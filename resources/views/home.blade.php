@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">لوحة التحكم</h1>
    </div>

    @include('common.alert')


    <div class="row">
        <div class="col-md-12">
{{--            <h2 class="text-center mb-3">اهلا وسهلا ب لوحة التحكم!</h2>--}}
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-10 mb-6">
            <h4 class="text-right mb-3">بيانات</h4>
        </div>

        <div class="col-xl-4 col-md-6 mb-4 text-right">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold  text-uppercase mb-1" style="font-size: 1.1rem">
                                <a href="{{ route("teamLeaders.index") }}" class="text-primary"> المسئولين </a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $teamLeaders->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4 text-right">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold  text-uppercase mb-1" style="font-size: 1.1rem">
                                <a href="{{ route("electoralCenters.index") }}" class="text-warning"> مراكز الإقتراع </a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $electoralCenters }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4 text-right">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold  text-uppercase mb-1" style="font-size: 1.1rem">
                                <a href="{{ route("individuals.index") }}" class="text-info"> الأفراد </a></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $individuals }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 mb-3 mt-3">
            <hr>
        </div>

    <!-- DataTales Example -->

    <div class="col-sm-12 mb-3 mt-3">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-right">كل المسئولين</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-info">
                            <th width="5%">#</th>
                            <th width="45%">اسم المسئول</th>
                            <th width="45%">عدد الأفراد</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($teamLeaders as $key =>$teamLeader)
                            <tr>
                                <td>{{++$key}}</td>
                                <td><a href="{{ route("teamLeaders.show", ['teamLeader' => $teamLeader->id]), }}">{{ $teamLeader->tl_name }}</td>
                                <td>{{ $teamLeader->individuals->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">لا يوجد بيانات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>


                <div class="col-sm-12 mb-3 mt-3">
            <hr>
        </div>

        </div>

    </div>



</div>
@endsection

