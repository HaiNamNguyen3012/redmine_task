<!DOCTYPE html>
<html lang="en">
<head>
    @include('user::elements.extent.meta')
    @include('user::elements.extent.style')
    @include('user::elements.extent.code_header')
</head>
<body class="has-header sidebar">
    @include('elements.code_body')
    @if(!isset($data["is_header"]))
        @include('user::elements.header')
    @endif
    @include('user::elements.nav')
    <main id="main-content" @if(isset($data["is_header"]))class="is_header"@endif>
        @yield('content')
    </main>
    @include('user::elements.extent.script')
    @include('user::elements.extent.code_body')
</body>
</html>
