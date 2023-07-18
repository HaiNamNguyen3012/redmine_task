@extends('user::layouts.sidebar')
@section('title-page') クレジットカード @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <form method="post" action="" id="form-data">
                @csrf
                <div id="wrap-form" class="wrap-form padding30">
                    @include('form.input.text', ["title" =>  "Số thẻ tín dụng*", "name" => "card_number", "value" => old("card_number"), "place" => "Số thẻ tín dụng"])
                    @include('form.input.text', ["title" =>  "Tên*", "name" => "card_name", "value" => old("card_name"), "place" => "Tên"])
                    <div class="form-group form-input">
                        <label for="">Ngày hết hạn*</label>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-6">
                                @include('form.input.text', ["title" => "", "name" => "month", "place" => "mm", "value" => old("month"), 'classLabel' => 'font-bold'])
                            </div>
                            <div class="col-md-6 col-sm-6 col-6">
                                @include('form.input.text', ["title" => "", "name" => "year", "place" => "yy", "value" => old("year"), 'classLabel' => 'font-bold'])
                            </div>
                        </div>
                    </div>
                    @include('form.input.text', ["title" => "CVC*", "name" => "card_cvc", "place" => "CVC", "value" => old("card_cvc"), 'classLabel' => 'font-bold' ,'classSelect' => 'select60'])
                </div>
                @if($errors->has('error'))
                    <div class="mt-3 mb-3 text-center">
                        <span class="help-block error-help-block" style="display: block">{{ $errors->first('error') }}</span>
                    </div>
                @endif
                @include('form.button.save', ["title" => "Save", "type" => "submit", "id" => ""])
                <a href="{{ route("user.mypage.show") }}">
                    @include('form.button.back', ["title" => "trở lại", "type" => "button", "id" => ""])
                </a>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\Card\CardRequest', '#form-data') !!}
@endsection
