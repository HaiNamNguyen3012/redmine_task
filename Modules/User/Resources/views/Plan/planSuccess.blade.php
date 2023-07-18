@extends('user::layouts.sidebar')

@section('content')


    <section class="wrap-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="box-370 page-confirm">
                        <form class="wrap-form" method="post" action="">
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('/static/images/plan_image.png') }}">
                            </div>
                            <h2 class="title-page">Hoàn thành thay đổi kế hoạch</h2>
                            <div class="box-amount no-border">
                                <div class="button_group">
                                    <a href="{{ route("user.plan.index") }}">
                                        @include('form.button.back', ["title" => "Trở lại", "type" => "button", "id" => ""])
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
@endsection
