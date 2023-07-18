@extends('user::layouts.sidebar')

@section('content')
    <section class="wrap-main">
        <div id="show-error"></div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-370 page-confirm">
                        <form class="wrap-form" method="post" action="">
                            @csrf
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('/static/images/plan_image.png') }}">
                            </div>
                            <h2 class="title-page">Kế hoạch tiêu chuẩn</h2>
                            <p class="detail-page"> Thay đổi kế hoạch?</p>
                            <div class="box-amount">
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="title">Tỷ lệ hàng ngày của tháng này</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="amount">¥{{ $data["plan_price"]["first_month"] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="title">tháng tiếp theo</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="amount">¥{{ $data["plan_price"]["next_month"] }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="title">消費税</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="amount">¥{{ $data["plan_price"]["vat"] }}</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="title">tổng cộng</p>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <p class="amount text-red">vnd{{ $data["plan_price"]["total"] }}</p>
                                    </div>
                                </div>
                                <div class="button_group">
                                    @if (empty(Auth::guard('users')->user()->customer_id))
                                        <a href="{{ route("user.card.edit") }}">
                                            <button type="button" class="btn btn-red btn-submit">thay đổi</button>
                                        </a>
                                    @else
                                        <button type="button" id="payment_cart" class="btn btn-red btn-submit">thay đổi
                                        </button>
                                    @endif

                                    <div class="clear"></div>
                                    <a href="{{ route("user.plan.index") }}">
                                        @include('form.button.back', ["title" => "trở lại", "type" => "button", "id" => ""])
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <input type="hidden" id="is_bought" value="0" />
@endsection

@section('scripts')
    <script type="text/javascript">
        document.getElementById("payment_cart").addEventListener("click", function () {

            //check
            $('#show-error').html("")

            var loading = document.getElementById("ajax-loading");
            loading.style.display = "block";
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                method: "POST",
                url: "{{ route('user.plan.confirm', ["id" => $data["detail"]->id]) }}",
                data: {}
            }).done(function (msg) {
                var data = msg.response;
                setInterval(function () {
                    checkPayment(data["url"]);
                }, 1000);
            }).fail(function (err) {
                //window.location.href = "";
                $('#show-error').html('<div class="alert alert-danger" role="alert">{{ config("sys_common.error")["plan_pay_error"] }}</div>')
            });
        });

        function checkPayment(url) {
            var is_bought = document.getElementById("is_bought").value;
            if(parseInt(is_bought) != parseInt(3)) {
                $('#show-error').html("")
                var loading = document.getElementById("ajax-loading");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val()
                    },
                    method: "POST",
                    url: url,
                    data: {}
                }).done(function (msg) {
                    var data = msg.response;
                    if (parseInt(data["is_bought"]) == parseInt(1)) {
                        window.location.href = "{{ route("user.plan.confirm.success") }}";
                    } else if (parseInt(data["is_bought"]) == parseInt(2)) {
                        document.getElementById("is_bought").value = "3";
                        loading.style.display = "none";
                        $('#show-error').html('<div class="alert alert-danger" role="alert">{{ config("sys_common.error")["plan_pay_error"] }}</div>')
                    }
                }).fail(function (err) {
                    document.getElementById("is_bought").value = "3";
                    $('#show-error').html('<div class="alert alert-danger" role="alert">{{ config("sys_common.error")["plan_pay_error"] }}</div>')
                });
            }
        }
    </script>
@endsection
