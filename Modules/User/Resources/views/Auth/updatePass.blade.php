@extends('user::layouts.no-sidebar')

@section('content')


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-login">
                        <form class="wrap-form" method="post" action="{{ route('user.register.postUpdatePass') }}"
                              id="form-login">
                            @csrf

                            <div class="title-page">
                                <h2>Vui lòng cập nhật mật khẩu mới</h2>
                            </div>
                            <div class="box-370">
                                <div class="form-group">
                                    <label class="title-input" for="password">Mật khẩu<span>*</span></label>
                                    <div class="input-pass">
                                        <input type="password" name="password" id="password" value=""
                                               placeholder="**********"
                                               class="form-control">
                                        <span class="eyes">
                                    <img class="img-fluid" src="{{ asset('/static/user/images/eyes_disable.png') }}">
                                </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="title-input" for="password">Xác nhận mật khẩu<span>*</span></label>
                                    <div class="input-pass">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               value="" placeholder="**********"
                                               class="form-control">
                                        <span class="eyes">
                                    <img class="img-fluid" src="{{ asset('/static/user/images/eyes_disable.png') }}">
                                </span>
                                    </div>
                                </div>
                                <input type="hidden" name="email" value="{{ request('email') ?? '' }}">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-color-red btn-submit">
                                        Đăng ký
                                    </button>
                                    <a href="{{ route('user.login.index') }}" class="btn btn-color-light btn-submit">
                                        Trở lại
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\UpdatePassRequest', '#form-login') !!}
@endsection
