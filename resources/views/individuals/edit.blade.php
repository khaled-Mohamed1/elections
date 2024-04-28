@extends('layouts.app')

@section('title', 'تعديل الفرد')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">تعديل الفرد</h1>
            <a href="{{route('individuals.index')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">رجوع <i
                    class="fas fa-arrow-left fa-sm text-white-50"></i></a>
        </div>

        {{-- Alert Messages --}}
        @include('common.alert')

        <!-- DataTales Example -->
        <div class="card shadow mb-4 text-right">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">تعديل الفرد</h6>
            </div>
            <form method="POST" action="{{route('individuals.update', ['individual' => $individual->id])}}">
                @csrf
                @method('PUT')

                <div class="card-body">
                    <div class="form-group row">


                        <input
                            type="hidden"
                            class="form-control form-control-user"
                            id="individual_id"
                            name="individual_id"
                            value="{{$individual->id}}">

                        {{-- i_NO --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم الفرد <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('i_NO') is-invalid @enderror"
                                id="i_NO"
                                name="i_NO"
                                value="{{ $individual->i_NO }}">
                            <span id="i_NO_error" class="text-danger"></span>
                            <span id="i_NO_success" class="text-success"></span>

                            @error('i_NO')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>


                        {{-- i_name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>اسم الفرد <span style="color:red;">*</span></label>
                            <input
                                type="text"
                                class="form-control form-control-user @error('i_name') is-invalid @enderror"
                                id="i_name"
                                name="i_name"
                                value="{{ $individual->i_name }}">

                            @error('i_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- i_phone_NO --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم هاتف الفرد </label>
                            <input
                                style="height: 45px;"
                                type="text"
                                class="form-control form-control-user @error('i_phone_NO') is-invalid @enderror"
                                id="i_phone_NO"
                                name="i_phone_NO"
                                value="{{ $individual->i_phone_NO }}">

                            @error('i_phone_NO')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- address --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>عنوان السكن <span style="color:red;">*</span></label>
                            <input
                                style="height: 45px;"
                                type="text"
                                class="form-control form-control-user @error('address') is-invalid @enderror"
                                id="address"
                                name="address"
                                value="{{ $individual->address }}">

                            @error('address')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- electoral_id --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>رقم مركز الإقتراع <span style="color:red;">*</span></label>
                            <select name="electoral_id" class="form-control form-control-user @error('electoral_id') is-invalid @enderror" style="height: 45px">
                                <option disabled {{ $individual->electoral_id == null ? 'selected' : '' }}>اختر...</option>
                                @foreach($electoralCenters as $electoralCenter)
                                    <option value="{{$electoralCenter->id}}" {{ $electoralCenter->id == $individual->electoral_id ? 'selected' : '' }}>{{$electoralCenter->ec_NO}}</option>
                                @endforeach
                            </select>
                            @error('electoral_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        {{-- electoral_name --}}
                        <div class="col-sm-6 mb-3 mt-3 mb-sm-0">
                            <label>اسم مركز الإقتراع</label>
                            <input
                                disabled
                                style="height: 45px;"
                                type="text"
                                class="form-control form-control-user"
                                name="electoral_name"
                                value="{{ $individual->electoralCenter->ec_name }}">
                        </div>

                        {{-- team_leader_id --}}
                        <div class="col-sm-12 mb-3 mt-3 mb-sm-0">
                            <label>اسم المسئول <span style="color:red;">*</span></label>
                            <select name="team_leader_id" class="form-control form-control-user @error('team_leader_id') is-invalid @enderror" style="height: 45px">
                                <option disabled {{ $individual->team_leader_id == null ? 'selected' : '' }}>اختر...</option>
                                @foreach($teamLeaders as $teamLeader)
                                    <option value="{{$teamLeader->id}}" {{ $teamLeader->id == $individual->team_leader_id ? 'selected' : '' }}>{{$teamLeader->tl_name}}</option>
                                @endforeach
                            </select>
                            @error('team_leader_id')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>


                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-user float-right mb-3">تعديل</button>
                    <a class="btn btn-primary float-right mr-3 mb-3" href="{{ route('individuals.index') }}">إلغاء</a>
                </div>
            </form>
        </div>

    </div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Get the select element and input element
        var selectElement = $('select[name="electoral_id"]');
        var inputElement = $('input[name="electoral_name"]');

        // Add event listener for change event on select element
        selectElement.on('change', function() {
            // Get the selected option
            var selectedOption = selectElement.find(':selected');
            var electoralCenterId = selectedOption.val(); // Get the ID of the selected electoral center

            console.log(electoralCenterId);

            // Make an AJAX request to fetch the name of the electoral center
            $.ajax({
                url: '{{ route("electoralCenters.get") }}', // Replace this URL with your actual route
                method: 'GET',
                data: { id: electoralCenterId },
                success: function(response) {
                    console.log(response);
                    // Update the value of the input element with the name of the electoral center
                    inputElement.val(response.name);
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors to the console
                }
            });
        });

        $('#i_NO').on('input', function() {
        var iNO = $(this).val();
            $.ajax({
                url: '{{ route("individuals.checkINO") }}',
                type: 'POST',
                data: {
                    i_NO: iNO,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if({{ $individual->i_NO }} == iNO){
                        $('#i_NO_error').text('');
                        $('#i_NO_success').text('');
                    }else{
                    if (response.exists) {
                        $('#i_NO_error').text('رقم الناخب تم إدخاله من قبل.');
                        $('#i_NO_success').text('');
                    } else {
                        $('#i_NO_error').text('');
                        $('#i_NO_success').text('رقم الناخب جديد.');
                    }
                    }

                }
            });
        });

    });
</script>
