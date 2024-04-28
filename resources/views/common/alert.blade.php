


{{-- Message --}}
@if (Session::has('success'))
    <div class="alert alert-success alert-dismissible text-right" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>بنجاح !</strong> {{ session('success') }}
    </div>
@endif

@if (Session::has('warning'))
    <div class="alert alert-warning alert-dismissible text-right" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>تحذير !</strong> {{ session('warning') }}
    </div>
@endif


@if (Session::has('error'))
    <div class="alert alert-danger alert-dismissible text-right" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <i class="fa fa-times"></i>
        </button>
        <strong>فشل !</strong> {{ session('error') }}
    </div>
@endif


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>

<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(() => {
            $("div .alert").remove();
        }, 7000);
    });
</script>

@endsection
