<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        @include('layouts.title-meta')
        @include('layouts.head')
  </head>

    @yield('body')
        @yield('content')
        @include('layouts.vendor-scripts')
    </body>
</html>