<!DOCTYPE html>
<html>
    <head>
        @include('includes.head')
        @toastr_css
    </head>
    <body>
        @yield('content')
    </body>
    @toastr_js
    @toastr_render
</html>