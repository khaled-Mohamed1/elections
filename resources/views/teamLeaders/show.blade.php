@extends('layouts.app')

@section('title', 'ملف الشخصي للمسئول')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
            <h1 class="h3 mb-3 text-gray-800">ملف مسئول الفريق</h1>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        {{-- Page Content --}}
        <div class="row">
            <div class="col-md-12 border-right">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">معلومات أساسية</h4>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary text-right">المسئول</h6>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr class="text-info">
                                    <th width="15%">اسم المستخدم</th>
                                    {{-- <th width="15%">اسم الفريق</th> --}}
                                    <th width="15%">رقم الهاتف الأول</th>
                                    <th width="15%">رقم الهاتف الثاني</th>
                                    <th width="15%">عنوان السكن</th>
                                    <th width="10%">عدد الأفراد</th>
                                    <th width="15%">تاريخ الإنشاء</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $teamLeader->tl_name }}</td>
                                        {{-- <td>{{ $teamLeader->tl_team_name }}</td> --}}
                                        <td>{{ $teamLeader->tl_phone_NO1 }}</td>
                                        <td>{{ $teamLeader->tl_phone_NO2 }}</td>
                                        <td>{{ $teamLeader->address }}</td>
                                        <td>{{ $teamLeader->individuals->count() }}</td>
                                        <td>{{ $teamLeader->created_at }}</td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-right">معلومات الأفراد</h4>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary text-right">الأفراد</h6>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr class="text-info">
                                    <th width="5%">#</th>
                                    <th width="15%">رقم الفرد</th>
                                    <th width="15%">اسم الفرد</th>
                                    <th width="15%">رقم الهاتف</th>
                                    <th width="15%">عنوان السكن</th>
                                    <th width="15%">مركز الإقتراع</th>
                                    <th width="10%">رقم مركز الإقتراع</th>
                                    <th width="15%">تاريخ الإنشاء</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teamLeader->individuals as $key => $individual)
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{ $individual->i_NO }}</td>
                                            <td>{{ $individual->i_name }}</td>
                                            <td>{{ $individual->i_phone_NO }}</td>
                                            <td>{{ $individual->address }}</td>
                                            <td>{{ $individual->electoralCenter->ec_name }}</td>
                                            <td>{{ $individual->electoralCenter->ec_NO }}</td>
                                            <td>{{ $individual->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

