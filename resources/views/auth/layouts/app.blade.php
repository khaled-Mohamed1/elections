<!DOCTYPE html>
<html lang="en">

{{-- Head Before AUTH--}}
@include('auth.includes.head')

<body style="font-family: Cairo,serif;">

    <div>

        {{-- Content Goes Here FOR Before AUTH --}}
        @yield('content')

    </div>

    {{-- Scripts Before AUTH --}}
    @include('auth.includes.scripts')

</body>

</html>
