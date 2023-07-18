@extends('user::layouts.no-sidebar')

@section('content')


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-370 form-login form-success">
                        <form class="wrap-form" method="post" action="">
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('/static/user/images/register-success.png') }}">
                            </div>

                            <h2 class="title-page">Xác minh email đã hoàn tất</h2>
                            <p>
                                Cảm ơn bạn<br>
                                Tài khoản của bạn đã được xác minh qua email
                            </p>
                            <div  class="form-group">
                                <a href="{{ route('user.login.index') }}" class="btn btn-color-red btn-submit"> ログイン画面へ </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
