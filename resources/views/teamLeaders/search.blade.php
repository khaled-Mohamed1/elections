@extends('layouts.app')

@section('title', 'البحث')

@section('content')
    <div class="container-fluid">
        {{-- Alert Messages --}}
        @include('common.alert')


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary text-right">المسئولين</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr class="text-info">
                            <th width="5%">#</th>
                            <th width="15%">اسم المستخدم</th>
                            {{-- <th width="15%">اسم الفريق</th> --}}
                            <th width="20%">رقم الهاتف الأول</th>
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
                                <td colspan="7">لا يوجد بيانات</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

    @include('teamLeaders.delete-modal')

@endsection

@section('scripts')

@endsection
