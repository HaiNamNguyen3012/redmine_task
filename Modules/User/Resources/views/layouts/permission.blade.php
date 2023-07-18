<!DOCTYPE html>
<html lang="en">
<head>
    @include('user::elements.extent.meta')
    @include('user::elements.extent.style_auth')
    @include('user::elements.extent.code_header')
</head>
<body class="bg-white per">
@yield('content')
@include('user::elements.extent.script')
@include('user::elements.extent.code_body')
</body>
</html>
