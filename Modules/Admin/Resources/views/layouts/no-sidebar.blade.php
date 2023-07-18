<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::elements.extent.meta')
    @include('admin::elements.extent.style_auth')
    @include('admin::elements.extent.code_header')
</head>
<body class="no-sidebar @if(isset($d_content)) d-content @endif ">
    @yield('content')

    @include('admin::elements.extent.script')
    @include('admin::elements.extent.code_body')
</body>
</html>
