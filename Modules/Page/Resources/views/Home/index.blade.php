@extends('page::layouts.home')
@section('content')

    <div id="slider">
        <div class="img">
            @if($mobile)
                <img class="img-fluid" src="{{ asset('static/images/slider_mb.png') }}" />
            @else
                <img class="img-fluid" src="{{ asset('static/images/slider_pc.png') }}" />
            @endif
        </div>
        <div class="content">
            <div class="text">
                Cho nhóm phát triển <br>
                Biểu đồ Gantt đơn giản nhất
            </div>
            <div class="link">
                <a href="{{ route('user.register.index') }}" class="btn btn-red">
                    Đăng ký miễn phí
                </a>
            </div>
        </div>
    </div>


    <div id="func">
        <div class="container">
            <div class="title title-home">
                <span>Chức năng</span>
            </div>
            <div class="box">
                <div class="item">
                    <div class="img">
                        <img src="{{ asset('static/images/function_1.jpeg') }}" class="img-fluid">
                    </div>
                    <div class="info">
                        <div class="name">Bảng chữ ký</div>
                        <div class="content">
                            Quản lý nhiệm vụ cho nhà phát triển hoặc nhà thiết kế trên một bảng
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="img">
                        <img src="{{ asset('static/images/function_2.jpeg') }}" class="img-fluid">
                    </div>
                    <div class="info">
                        <div class="name">Biểu đồ Gantt</div>
                        <div class="content">
                            Xem các nhiêm vụ phát triển theo lịch biểu trong biểu đồ Gantt
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div id="plan">
        <div class="container">
            <div class="title title-home">
                <span>Kế hoạch</span>
            </div>
            <div class="box">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="item"><img src="{{ asset('static/images/plan_1.jpeg') }}" class="img-fluid"></div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="item"><img src="{{ asset('static/images/plan_2.jpeg') }}" class="img-fluid"></div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="item"><img src="{{ asset('static/images/plan_3.jpeg') }}" class="img-fluid"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="button_register button_register-mb">
            <a href="{{ route('user.register.index') }}" class="btn btn-red btn-register">
                Đăng ký miễn phí
            </a>
        </div>
    </div>

@endsection
