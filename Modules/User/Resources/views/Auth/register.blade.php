@extends('user::layouts.no-sidebar')

@section('content')


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-370 form-login">
                        <form class="wrap-form" method="post" action="" id="form-login">
                            @csrf
                            <div class="title-page">
                                Tạo tài khoản mới
                            </div>
                            <div class="form-group">
                                <label class="title-input" for="email">Email<span>*</span></label>
                                <input type="text" name="email" value="" placeholder="email address"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="title-input" for="password">Mật khẩu<span>*</span></label>
                                <div class="input-pass">
                                    <input type="password" name="password" id="password" value="" placeholder="**********"
                                           class="form-control">
                                    <span class="eyes">
                                    <img class="img-fluid" src="{{ asset('/static/user/images/eyes_disable.png') }}">
                                </span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="title-input" for="password">Xác nhận mật khẩu<span>*</span></label>
                                <div class="input-pass">
                                    <input type="password" name="password_confirmation" id="password_confirmation" value="" placeholder="**********"
                                           class="form-control">
                                    <span class="eyes">
                                    <img class="img-fluid" src="{{ asset('/static/user/images/eyes_disable.png') }}">
                                </span>
                                </div>
                            </div>

                            <div  class="form-group">
                                <button type="submit" class="btn btn-color-red btn-submit">
                                    Đăng ký
                                </button>
                            </div>

                            <p class="click">Bấm vào đây nếu bạn đã có một tài khoản <a href="{{ route('user.login.index') }}" class="click underline">Đăng nhập</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\RegisterRequest', '#form-login') !!}
@endsection
