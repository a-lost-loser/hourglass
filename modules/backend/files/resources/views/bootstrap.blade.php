<!DOCTYPE html>
<html>
    <head>
        @section('metadata')
            <meta charset="utf-8">
        @show

        @yield('head')

        @yield('links')
    </head>

    <body>
        @yield('content')

        @yield('scripts')
    </body>
</html>