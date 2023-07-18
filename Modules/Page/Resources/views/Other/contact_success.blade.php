@extends('page::layouts.home')
@section('content')
    <div class="banner-page banner-page-contact">
        <div class="box-content-banner-index">
            <h1>お問い合わせ</h1>
        </div>
        <img class="img-fluid" src="{{ asset('static/images/banner_contact.png') }}"/>
    </div>
    <div id="contact-content" class="page-content page-contact-success">
        <div class="container container-page">
            <div class="row">
                <div class="col-md-12">
                    <div class="contact-success text-center">
                        <p class="font-bold">GỬi hoàn thành</p>
                        <p>Người phụ trách sẽ gửi e-mail đến địa chỉ e-mail bạn đã nhập sau khi xác nhận.</p>
                        <p>Có thể mất 2-3 ngày làm việc để trả lời. Tôi đánh giá cao nếu bạn có thể chờ đợi một thời gian.</p>
                    </div>
                    <div id="contact" class="box-370">

                        <div class="col-auto">
                            <a href="{{ route('page.home.index') }}" class="btn btn-primary submit">トップページに戻る</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
