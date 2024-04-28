@extends('layouts.app')

@section('title', 'ملف الشخصي للموظف')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
            <h1 class="h3 mb-3 text-gray-800">ملف الموظف</h1>
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
                        <h6 class="m-0 font-weight-bold text-primary text-right">الموظف</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="text-info">
                                        <th width="20%">الاسم</th>
                                        <th width="25%">البريد الإلكتروني</th>
                                        <th width="15%">رقم الجوال</th>
                                        <th width="15%">الوظيفة</th>
                                        <th width="15%">حالة النشاط</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->mobile_number }}</td>
                                        <td>{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</td>
                                        <td>
                                            @if ($user->status == 0)
                                                <span class="badge badge-danger">غير نشط</span>
                                            @elseif ($user->status == 1)
                                                <span class="badge badge-success">نشط</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>

            </div>
        </div>
    </div>
@endsection
