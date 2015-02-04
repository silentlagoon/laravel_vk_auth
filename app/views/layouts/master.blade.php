<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <link href="{{ asset('libs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('site.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>