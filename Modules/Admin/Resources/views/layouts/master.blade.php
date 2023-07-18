<!DOCTYPE html>
<html lang="en">
    <head>
        @include('admin::elements.extent.meta')
        @include('admin::elements.extent.style')
        @include('admin::elements.extent.code_header')
    </head>
    <body>
        @yield('content')
        @include('admin::elements.extent.script')
        @include('admin::elements.extent.code_body')
    </body>
</html>
