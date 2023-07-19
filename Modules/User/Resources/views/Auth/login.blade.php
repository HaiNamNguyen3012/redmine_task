@extends('user::layouts.no-sidebar')

@section('content')


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-370 form-login">
                        <form class="wrap-form" id="form-login" method="post" action="">



                            @csrf
                            <div class="title-page">
                                Đăng nhập
                            </div>
                            <div class="form-group">
                                <label class="title-input" for="email">Email<span>*</span></label>
                                <input type="text" name="email" value="" placeholder="email address"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="title-input" for="password">Mật khẩu<span>*</span></label>
                                <div class="input-pass">
                                    <input type="password" name="password" value="" placeholder="**********"
                                           class="form-control">
                                    <span class="eyes">
                                    <img class="img-fluid" src="{{ asset('/static/user/images/eyes_disable.png') }}">
                                </span>
                                </div>
                            </div>
                            @if($errors->has('errors'))
                                <div class="alert alert-danger" role="alert">
                                    {{$errors->first('errors')}}
                                </div>
                            @endif
                            <div  class="form-group">
                                <button type="submit" class="btn btn-color-red btn-submit">
                                    Đăng nhập
                                </button>
                            </div>



                            <a href="{{ route('user.register.index') }}" class="click underline">Tạo tài khoản</a>
                            <div class="clear mb-0"></div>
                            <a href="{{ route('user.forgot.pass') }}" class="click underline mt-0">Bạn quên mật khẩu?</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
{!! JsValidator::formRequest('Modules\User\Http\Requests\LoginRequest', '#form-login') !!}
@endsection
