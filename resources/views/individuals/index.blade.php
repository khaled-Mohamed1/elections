@extends('layouts.app')

@section('title', 'بيانات الأفراد')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">الأفراد</h1>
            <div class="row">
                {{-- <div class="col-md-6">
                    <a href="{{ route('issues.index') }}" class="btn btn-sm btn-info">
                        رجوع للقضايا <i class="fas fa-plus"></i>
                    </a>
                </div> --}}
                <div class="col-md-5">
                    <a href="{{ route('individuals.create') }}" class="btn btn-sm btn-primary mt-1">
                        اضافة فرد <i class="fas fa-plus"></i>
                    </a>
                </div>

                <div class="col-md-7">
                    <form action="{{ route("individuals.search") }}" method="GET" class="d-none d-sm-inline-block form-inline ml-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
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
                <h6 class="m-0 font-weight-bold text-primary text-right">كل الأفراد</h6>

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
                            <th width="15%">رقم مركز الإقتراع</th>
                            <th width="15%">اسم المسئول</th>
                            <th width="10%">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($individuals as $key =>$individual)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{ $individual->i_NO }}</td>
                                <td>{{ $individual->i_name }}</td>
                                <td>{{ $individual->i_phone_NO }}</td>
                                <td>{{ $individual->address }}</td>
                                <td>{{ $individual->electoralCenter->ec_name ?? " "}}</td>
                                <td>{{ $individual->electoralCenter->ec_NO ?? ""}}</td>
                                <td>{{ $individual->teamLeader->tl_name ?? " " }}</td>
                                <td style="display: flex">
                                    <a href="{{ route('individuals.edit', ['individual' => $individual->id]) }}"
                                        class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal{{$individual->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">لا يوجد بيانات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $individuals->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('individuals.delete-modal')

@endsection

@section('scripts')

@endsection
