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

                            <h2 class="title-page">Gửi email xác thực</h2>
                            <p>
                                Đến email bạn đã nhập<br>
                                Đã gửi email xác minh
                            </p>


                            <div  class="form-group">
                                <a href="{{ route('page.home.index') }}" class="btn btn-color-red btn-submit"> Trở về trang chủ</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
