@extends('layouts.app')

@section('title', 'بيانات المسئولين')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">المسئولين</h1>
            <div class="row">

                <div class="col-md-5">
                    <a href="{{ route('teamLeaders.create') }}" class="btn btn-sm btn-primary mt-1">
                        اضافة مسئول <i class="fas fa-plus"></i>
                    </a>
                </div>

                <div class="col-md-7">
                    <form action="{{ route("teamLeaders.search") }}" method="GET" class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        @csrf
                        <div class="input-group">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                            <input required type="text" class="form-control bg-white border-0 small" required name="search" style="margin-right: 0;" placeholder="بحث ..."
                                aria-label="Search" aria-describedby="basic-addon2">
                        </div>
                    </form>
                </div>

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-right">كل المسئولين</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-info">
                            <th>#</th>
                            <th width="15%">اسم المستخدم</th>
                            <th width="15%">اسم الفريق</th>
                            {{-- <th width="20%">رقم الهاتف الأول</th> --}}
                            <th width="20%">رقم الهاتف الثاني</th>
                            <th width="20%">عنوان السكن</th>
                            <th width="20%">عدد الأفراد</th>
                            <th width="20%">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($teamLeaders as $key =>$teamLeader)
                            <tr>
                                <td>{{++$key}}</td>
                                <td><a href="{{ route("teamLeaders.show", ['teamLeader' => $teamLeader->id]), }}">{{ $teamLeader->tl_name }}</td>
                                {{-- <td>{{ $teamLeader->tl_team_name }}</td> --}}
                                <td>{{ $teamLeader->tl_phone_NO1 }}</td>
                                <td>{{ $teamLeader->tl_phone_NO2 }}</td>
                                <td>{{ $teamLeader->address }}</td>
                                <td>{{ $teamLeader->individuals->count() }}</td>
                                <td style="display: flex">
                                    <a href="{{ route('teamLeaders.edit', ['teamLeader' => $teamLeader->id]) }}"
                                        class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal{{$teamLeader->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">لا يوجد بيانات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $teamLeaders->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('teamLeaders.delete-modal')

@endsection

@section('scripts')

@endsection
