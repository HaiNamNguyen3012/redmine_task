@extends('user::layouts.sidebar')

@section('content')
    <form class="wrap-form" method="post" action="">
        @csrf
        <section class="wrap-main">
            <div id="show-error"></div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box-370 page-confirm">
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('/static/images/plan_image.png') }}">
                            </div>
                            <h2 class="title-page">Bạn có muốn đổi sang gói miễn phí không?</h2>
                            <p class="detail-page">{{ $data["plan_bought"]["time"] }}Gói trả phí có sẵn lên đến</p>
                            <div class="box-amount no-border">
                                <div class="button_group">
                                    <button type="button" id="payment_cart" class="btn btn-red btn-submit">thay đổi</button>
                                    <div class="clear"></div>
                                    <a href="{{ route("user.plan.index") }}">
                                        @include('form.button.back', ["title" => "Trở lại", "type" => "button", "id" => ""])
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
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
                url: "{{ route('user.plan.change.free', ["id" => $data["detail"]->id]) }}",
                data: {}
            }).done(function (msg) {
                var data = msg.response;
                window.location.href = "{{ route("user.plan.confirm.success") }}";
            }).fail(function (err) {
                $('#show-error').html('<div class="alert alert-danger" role="alert">{{ config("sys_common.error")["plan_pay_error"] }}</div>')
            });
        });
    </script>
@endsection
