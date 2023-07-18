@extends('page::layouts.home')
@section('content')
    <div class="banner-page banner-page-contact">
        <div class="box-content-banner-index">
            <h1>Cuộc điều tra</h1>
        </div>
        <img class="img-fluid" src="{{ asset('static/images/banner_contact.png') }}"/>
    </div>
    <div id="contact-content" class="page-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-padd">
                    <form method="post" action="" id="form-login">
                        @csrf
                        <div id="contact" class="box-370">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email address">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Tên*</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Tên">
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Nội dung</label>
                                <textarea  class="form-control" name="detail" id="detail" placeholder="Nội dung"></textarea>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-red submit">Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('Modules\Page\Http\Requests\ContactRequest', '#form-login') !!}
@endsection
