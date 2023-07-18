@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/lib/datepicker/css/bootstrap-datepicker.min.css')}}">
@endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                <form class="" method="get" id="form">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            @include('form.input.month', ["title" =>  "月", "name" => "start_date", "place" => "yyyy/mm", "value" => "" ,"class" => 'monthpicker'])
                        </div>
                        <div class="col-md-4 col-sm-4">
                            @include('form.select.select', ["title" =>  "hiển thị", "name" => "user_id", "place" => "", $option_arr = [], "value" => ""])
                        </div>
                        <div class="col-md-4 col-sm-4">
                            @include('form.select.select_custom_background', ["name" => "status", "title" => "trạng thái", "place" => "trạng thái", $option_arr = config("sys_common.status"), "value" => "2"])
                        </div>
                    </div>
                </form>
            </div>

            <div class="gantt_chart">
                <div class="head">
                    <div class="title">Member</div>
                    <div class="day">
                        @for($x = 1; $x <= $data['listDay']; $x++)
                            @php
                                $style = 'bg-white';
                                if ($x % 2 == 0) $style = '';
                            @endphp
                            <div class="item {{ $style }}">
                                <div class="text">@if($x<10){{ 0 }}@endif{{ $x }}</div>
                                <div class="text">{{ config("sys_common.day")[$x] }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="list-member">
                    <div class="member">
                        <div class="name">
                            Member.name 1
                        </div>
                        <div class="list-task">
                            <div class="task">
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item" >
                                    <div class="detail-task hide-name high-task">
                                        <p>Task.name</p>
                                    </div>
                                </div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                            </div>
                            <div class="task">
                                <div class="task">
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item" style="width: 68px">
                                        <div class="detail-task hide-name usually-task" style="width: 68px"
                                             data-toggle="tooltip"
                                             data-placement="bottom"
                                             title="Tooltip text here">
                                            <p>Task.name</p>
                                        </div>
                                    </div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                </div>
                            </div>
                            <div class="task">
                                <div class="task">
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item" style="width: 340px">
                                        <div class="detail-task low-task" style="width: 340px">
                                            <p>Task.name</p>
                                        </div>
                                    </div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                    <div class="member">
                        <div class="name">
                            Member.name 2
                        </div>
                        <div class="list-task">
                            <div class="task">
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item" style="width: 170px">
                                    <div class="detail-task high-task" style="width: 170px">
                                        <p>Task.name</p>
                                    </div>
                                </div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                                <div class="item"></div>
                            </div>
                            <div class="task">
                                <div class="task">
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item" style="width: 340px">
                                        <div class="detail-task usually-task" style="width: 340px">
                                            <p>Task.name</p>
                                        </div>
                                    </div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                </div>
                            </div>
                            <div class="task">
                                <div class="task">
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item" style="width: 340px">
                                        <div class="detail-task low-task" style="width: 340px">
                                            <p>Task.name</p>
                                        </div>
                                    </div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                    <div class="item"></div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>

                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
