@extends('user::layouts.no-sidebar')

@section('content')


    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class=" form-login">
                        <form class="wrap-form" id="form-login" method="post" action="">

                            @csrf
                            <div class="title-page">
                                <h2>Địa chỉ email đã đăng ký</h2>
                                <p class="small">Vui lòng nập</p>
                            </div>
                            <div class="box-370">
                                <div class="form-group">
                                    <label class="title-input" for="email">Email<span>*</span></label>
                                    <input type="text" name="email" value="" placeholder="email address"
                                           class="form-control">
                                </div>
                                @if($errors->has('errors'))
                                    <div class="alert alert-danger" role="alert">
                                        {{$errors->first('errors')}}
                                    </div>
                                @endif
                                <div class="form-group">
                                    <button type="submit" class="btn btn-color-red btn-submit"> Gửi</button>
                                    <a href="{{ route('user.login.index') }}"
                                       class="btn btn-color-light btn-submit">Trở lại</a>
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
    {!! JsValidator::formRequest('Modules\User\Http\Requests\ForgotPassRequest', '#form-login') !!}
@endsection
