<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin::elements.extent.meta')
    @include('admin::elements.extent.style')
    @include('admin::elements.extent.code_header')
</head>
<body class="has-header sidebar">
    @if(!isset($data["is_header"]))
        @include('admin::elements.header')
    @endif
    @include('admin::elements.nav')
    <main id="main-content" @if(isset($data["is_header"]))class="is_header"@endif>
        @yield('content')
    </main>
    @include('admin::elements.extent.script')
    @include('admin::elements.extent.code_body')
</body>
</html>
