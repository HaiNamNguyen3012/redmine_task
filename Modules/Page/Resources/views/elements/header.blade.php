<header class="page">
    <div class="container container-full">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-5">
                <div class="logo">
                    <a href="{{ route("page.home.index") }}">
                        <img class="img-fluid" src="{{ asset('static/images/logo_page.jpeg') }}"/>
{{--                        <img class="logo-mb" src="{{ asset('static/page/images/logo.png') }}" style="display: none;" />--}}
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-7">
                <div class="nav">
                    <div class="icon-bar-menu">
                        <span></span>
                    </div>
                    <nav id="wrap-menu-header">
                        <ul>
                            <li class=""><a href="{{ route('user.login.index') }}" class="active">Login</a></li>
                            <li class=""><a href="{{ route('user.register.index') }}" class="">Tạo tài khoản</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>

