@extends('user::layouts.sidebar')

@section('title-page') {{ $data->name }} @endsection
@section('content')
    <section class="wrap-main user-detail-page">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                <a href="{{ route('user.mypage.edit') }}" class="edit-button">
                    <img src="{{ asset('static/user/images/edit_button.png') }}">
                </a>
                <div class="list-info">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="item">
                                <span>Email : </span>
                                <span class="font-bold">{{ @$data->email ?? '' }}</span>
                            </div>
                            <div class="item">
                                <span>Tên :  </span>
                                <span class="font-bold">{{ @$data->name ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="title-box">Thẻ tín dụng</p>
            <div id="wrap-form" class="wrap-form detail-task padding30">
                <a href="{{ route("user.card.edit") }}" class="edit-button">
                    <img src="{{ asset('static/user/images/edit_button.png') }}">
                </a>
                <div class="list-info">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="item">
                                <span>
                                    @if(empty($data->customer_id))
                                       Chưa đăng ký
                                    @else
                                        **** -**** - **** - {{ $data->card_number }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
