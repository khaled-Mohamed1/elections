@extends('layouts.app')

@section('title', 'البحث')

@section('content')
    <div class="container-fluid">
        {{-- Alert Messages --}}
        @include('common.alert')


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
                                <td>{{ $individual->electoralCenter->ec_NO ?? " "}}</td>
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
                                <td colspan="8">لا يوجد بيانات</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

        @include('individuals.delete-modal')


@endsection

@section('scripts')

@endsection
