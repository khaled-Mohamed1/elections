@extends('layouts.app')

@section('title', 'الوظائف')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">الوظائف</h1>
        <a href="{{route('roles.create')}}" class="btn btn-sm btn-primary" >
             اضافة جديد <i class="fas fa-plus"></i>
        </a>
    </div>

    {{-- Alert Messages --}}
    @include('common.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary text-right">كل الوظائف</h6>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-right" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr class="text-info">
                            <th width="40%">الإسم الوظيفة</th>
                            <th width="40%">نوع</th>
                            <th width="20%">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($roles as $role)
                           <tr>
                               <td>{{$role->name}}</td>
                               <td>{{$role->guard_name}}</td>
                               <td style="display: flex">
                                   <a href="{{ route('roles.edit', ['role' => $role->id]) }}" class="btn btn-primary m-2">
                                        <i class="fa fa-pen"></i>
                                   </a>
                                   <form method="POST" action="{{ route('roles.destroy', ['role' => $role->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger m-2" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                   </form>
                               </td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>

                {{$roles->links()}}
            </div>
        </div>
    </div>

</div>


@endsection
