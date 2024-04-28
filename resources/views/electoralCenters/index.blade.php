@extends('layouts.app')

@section('title', 'بيانات مراكز الإقتراع')

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">مراكز الإقتراع</h1>
            <div class="row">
                {{-- <div class="col-md-6">
                    <a href="{{ route('issues.index') }}" class="btn btn-sm btn-info">
                        رجوع للقضايا <i class="fas fa-plus"></i>
                    </a>
                </div> --}}
                <div class="col-md-12">
                    <a href="{{ route('electoralCenters.create') }}" class="btn btn-sm btn-primary">
                        اضافة مركز إقتراع <i class="fas fa-plus"></i>
                    </a>
                </div>

            </div>

        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-right">كل المراكز</h6>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-info">
                            <th width="5%">#</th>
                            <th width="40%">اسم مركز الإقتراع</th>
                            <th width="40%">رقم التسلسلي</th>
                            <th width="10%">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($electoralCenters as $key =>$electoralCenter)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{ $electoralCenter->ec_name }}</td>
                                <td>{{ $electoralCenter->ec_NO }}</td>
                                <td style="display: flex">
                                    <a href="{{ route('electoralCenters.edit', ['electoralCenter' => $electoralCenter->id]) }}"
                                        class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <a class="btn btn-danger m-2" href="#" data-toggle="modal" data-target="#deleteModal{{$electoralCenter->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">لا يوجد بيانات</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    {{ $electoralCenters->links() }}
                </div>
            </div>
        </div>

    </div>

    @include('electoralCenters.delete-modal')

@endsection

@section('scripts')

@endsection
