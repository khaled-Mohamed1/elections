@extends('layouts.app')

@section('title', 'الموظفين')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الموظفين</h1>
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
                         اضافة جديد <i class="fas fa-plus"></i>
                    </a>
                </div>
                {{-- Additional option for exporting data --}}
                {{-- <div class="col-md-6">
                    <a href="{{ route('users.export') }}" class="btn btn-sm btn-success" >
                        نصدير اكسل <i class="fas fa-check"></i>
                    </a>
                </div> --}}

            </div>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-right">كل الموظفين</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="20%">اسم</th>
                                <th width="25%">البريد الإلكتروني</th>
                                <th width="15%">رقم الجوال</th>
                                <th width="15%">الوظيفة</th>
                                <th width="15%">كلمة السر</th>
                                <th width="10%">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td><a href="{{route('users.show',['user' => $user->id])}}">{{ $user->full_name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->mobile_number }}</td>
                                    <td>{{ $user->roles ? $user->roles->pluck('name')->first() : 'N/A' }}</td>
                                    <td>{{ $user->not_hash_password }}</td>
                                    <td style="display: flex">
                                        <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                            class="btn btn-primary m-2">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                        <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for delete confirmation --}}
    @include('users.delete-modal')

@endsection

@section('scripts')
    {{-- Additional scripts --}}
@endsection
