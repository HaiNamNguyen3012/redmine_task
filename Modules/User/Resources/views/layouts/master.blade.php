<!DOCTYPE html>
<html lang="en">
    <head>
        @include('user::elements.extent.meta')
        @include('user::elements.extent.style')
        @include('user::elements.extent.code_header')
    </head>
    <body>
        @yield('content')
        @include('user::elements.extent.script')
        @include('user::elements.extent.code_body')
    </body>
</html>
