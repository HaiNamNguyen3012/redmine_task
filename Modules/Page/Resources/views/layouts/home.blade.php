<!DOCTYPE html>
<html lang="en">
<head>
    @include('page::elements.extent.meta')
    @include('page::elements.extent.style')
    @include('page::elements.extent.code_header')
</head>
<body>
@include('page::elements.header')
<main id="main-content">
    @yield('content')
</main>
@include('page::elements.footer')
@include('page::elements.extent.script')
@include('page::elements.extent.code_body')
</body>
</html>
