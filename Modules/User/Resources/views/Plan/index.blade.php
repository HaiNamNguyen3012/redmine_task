@extends('user::layouts.sidebar')

@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div class="plan_wrap">

                @if(!$data["plan_bought"]["is_expire"] && !empty($data["plan_bought"]["time"]))
                    <div class="text-center plan-title-use">
                        <label class="font-bold font-20">{{ $data["plan_bought"]["time"] }}Gói trả phí có thể được sử dụng lên đến</label>
                    </div>
                @endif
                <div class="row">
                    @foreach($data["plan"] as $k => $row)
                        <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                            <div class="box_plan">
                                <div class="img">
                                    <img class="img-fluid" src="{{ asset('/static/images/plan_'.($k + 1).'.png') }}">
                                </div>
                                <h2 class="title">{{ $row->name }}</h2>
                                <h3 class="price">{{ ($row->price > 0) ? "vnd".$row->price."(Không bao gồm thuế)" : "Miễn phí" }}</h3>
                                <ul>
                                    <li>{{ ($row->price == 0) ? "Tối đa 1 dự án" : "Không giới hạn dự án" }}</li>
                                </ul>
                                <div class="click">
                                    @if($row->price > 0)
                                        @if (Auth::guard('users')->user()->plan_id == $row->id)
                                            @if($data["plan_bought"]["plan_bought_by_time"])
                                                <a href="javascript:void(0)" class="btn btn-red not-cursor">lựa chọn</a>
                                            @else
                                                <a href="{{ route("user.plan.confirm", ["id" => $row->id]) }}"
                                                   class="btn btn-red">lựa chọn</a>
                                            @endif
                                        @else
                                            @if($data["plan_bought"]["plan_bought_by_time"])
                                                <a href="javascript:void(0)" class="btn btn-red not-cursor">lựa chọn</a>
                                            @else
                                                <a href="{{ route("user.plan.confirm", ["id" => $row->id]) }}"
                                                   class="btn btn-red">lựa chọn</a>
                                            @endif
                                        @endif
                                    @else
                                        @if (Auth::guard('users')->user()->plan_id == $row->id)
                                            <a href="javascript:void(0)" class="btn btn-red not-cursor">lựa chọn</a>
                                        @else
                                            @if(!$data["plan_bought"]["plan_bought_by_time"])
                                                <a href="javascript:void(0)" class="btn btn-red not-cursor">lựa chọn</a>
                                            @else
                                                <a href="{{ route("user.plan.confirm", ["id" => $row->id]) }}"
                                                   class="btn btn-red">lựa chọn</a>
                                            @endif
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{--                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">--}}
                    {{--                        <div class="box_plan">--}}
                    {{--                            <div class="img">--}}
                    {{--                                <img class="img-fluid" src="{{ asset('/static/images/plan_2.png') }}">--}}
                    {{--                            </div>--}}
                    {{--                            <h2 class="title">スタンダートプラン</h2>--}}
                    {{--                            <h3 class="price">¥3000(税抜)</h3>--}}
                    {{--                            <ul>--}}
                    {{--                                <li>プロジェクト無制限</li>--}}
                    {{--                            </ul>--}}
                    {{--                            <div class="click">--}}
                    {{--                                <a href="#" class="btn btn-red">選択する</a>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                        <div class="box_plan">
                            <div class="img">
                                <img class="img-fluid" src="{{ asset('/static/images/plan_3.png') }}">
                            </div>
                            <h2 class="title">doanh nghiệp</h2>
                            <h3 class="price">liên hệ</h3>
                            <ul>
                                <li>Không giới hạn dự án</li>
                                <li>Sẵn sàng an toàn</li>
                                <li>sao lưu dữ liệu</li>
                            </ul>
                            <div class="click">
                                <a href="{{ route("page.contact.index") }}" class="btn btn-red">liên hệ</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
