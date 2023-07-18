@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    @php
        $listStatus = [];
        if (!empty($arr_project_status)) {
            foreach ($arr_project_status as $k => $v){
                $listStatus[$k] = $v['title'];
            }
        }
    @endphp
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                <form class="" method="get" id="form">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            @include('form.input.month', ["title" =>  "ngày", "name" => "start_date", "place" => "yyyy/mm", "value" => (\request()->has("start_date") ? \request()->get("start_date") : date("Y/m")), "class" => 'monthpicker', 'submit' => true ])
                        </div>
                        <div class="col-md-4 col-sm-4">
                            @include('form.select.select', ["title" =>  "Hiển thị", "name" => "display", "place" => "", $option_arr = config("sys_common.find_option"), "value" => (\request()->has("display") ? \request()->get("display") : "person"), 'submit' => true, 'default' => false ])
                        </div>
                        <div class="col-md-4 col-sm-4">
                            @include('form.select.select', ["name" => "status", "title" => "trạng thái", "place" => "", $option_arr = $listStatus, "value" => (\request()->has("status") ? \request()->get("status") : "") , 'submit' => true ])
                        </div>
                    </div>
                </form>
            </div>

            <div class="gantt_chart">
                <div class="head">
                    <div class="title">Tiêu đề</div>
                    <div class="day">
                        @for($x = 1; $x <= $data['listDay']; $x++)
                            @php
                                $dateTime = $data['year'].'-'.$data['month'].'-'.$x;
                                $weed = \App\Helpers\Helpers::getWeekday(strtotime($dateTime));
                                $style = 'bg-white';
                                if ($x % 2 == 0) $style = '';
                            @endphp
                            <div class="item {{ $style }}" data-weed="{{ $weed }}">
                                <div class="text">@if($x<10){{ 0 }}@endif{{ $x }}</div>
                                <div class="text">{{ config("sys_common.day")[$weed] }}</div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="list-member">
                    @foreach($data["task_for_category"] as $k => $tasks)
                        @if(!empty($tasks))
                        <div class="member">
                            @php
                                $count = 0;
                            @endphp
                            @foreach($tasks as $row)
                                @if(!empty($row['start_date']) && !empty($row['end_date']))
                                    @php $count++ @endphp
                                @endif
                            @endforeach
                            @if($count > 0)
                            <div class="name">
                                {{ !empty(config("sys_common.task_category")[$k]) ? config("sys_common.task_category")[$k] : "" }}
                            </div>
                            @endif
                            <div class="list-task">
                                @foreach($tasks as $row)
                                    @if(!empty($row['start_date']) && !empty($row['end_date']))
                                    <div class="task">
                                        @php $dem = 0; @endphp
                                        @for($x = 1; $x <= $data['listDay']; $x++)
                                            @php $day = ($row["point_end"] - $row["point_start"]) + 1; @endphp

                                            @if($x >= $row["point_start"] && $x <=  $row["point_end"])
                                                @php $dem ++; @endphp

                                                @if($dem == 1)
                                                    <div class="item" style="width: {{ $day * 34 }}px">
                                                        <a href="{{ route('admin.task.show', ['id' => $row["id"]]) }}" target="_blank">
                                                            <div
                                                                class="detail-task {{ ($day <= 2) ? "hide-name" : "" }} {{ in_array($row['status_project']['key_status'], \App\Helpers\Helpers::txtRandom(true)) ? "ct-".$row['status_project']['key_status'] : $row['status_project']['key_status'] }}-task"
                                                                style="width: {{ $day * 34 }}px"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="{{ $row["name"].' '.$row["details"] }}">
                                                                <p>{{ $row["name"] }}</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="item"></div>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                @endforeach
                                @if(empty($tasks))
                                    <div class="task">
                                        @for($x = 1; $x <= $data['listDay']; $x++)
                                            <div class="item"></div>
                                        @endfor
                                    </div>
                                @endif
                            </div>
                            <div class="clear"></div>
                        </div>
                        @endif
                    @endforeach
                    @foreach($data["task_empty"] as $k => $tasks)
                        <div class="member">
                            @php
                                $count = 0;
                            @endphp
                            @foreach($tasks as $row)
                                @if(!empty($row['start_date']) && !empty($row['end_date']))
                                    @php $count++ @endphp
                                @endif
                            @endforeach
                            @if($count > 0)
                            <div class="name">
                                Chưa được chọn
                            </div>
                            @endif
                            <div class="list-task">
                                @foreach($tasks as $row)
                                    @if(!empty($row['start_date']) && !empty($row['end_date']))
                                    <div class="task">
                                        @php $dem = 0; @endphp
                                        @for($x = 1; $x <= $data['listDay']; $x++)
                                            @php $day = ($row["point_end"] - $row["point_start"]) + 1; @endphp

                                            @if($x >= $row["point_start"] && $x <=  $row["point_end"])
                                                @php $dem ++; @endphp

                                                @if($dem == 1)
                                                    <div class="item" style="width: {{ $day * 34 }}px">
                                                        <a href="{{ route('admin.task.show', ['id' => $row["id"]]) }}" target="_blank">
                                                            <div
                                                                class="detail-task {{ ($day <= 2) ? "hide-name" : "" }} {{ in_array($row['status_project']['key_status'], \App\Helpers\Helpers::txtRandom(true)) ? "ct-".$row['status_project']['key_status'] : $row['status_project']['key_status'] }}-task"
                                                                style="width: {{ $day * 34 }}px"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="{{ $row["name"].' '.$row["details"] }}">
                                                                <p>{{ $row["name"] }}</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="item"></div>
                                            @endif
                                        @endfor
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <div class="clear"></div>
                        </div>
                    @endforeach
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('/lib/datepicker/css/bootstrap-datepicker.min.css')}}">
@endsection

@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(".member").each(function (i, v) {
            var name_height = v.querySelector(".name").clientHeight;
            var list_task = v.querySelectorAll(".list-task .task").length
            var arr_list_task = v.querySelectorAll(".list-task .task")
            if (parseInt(list_task) > 0) {
                if (parseInt(name_height) > (parseInt(list_task) * 40)) {
                    var h = name_height / list_task;
                    for (var i = 0; i < list_task; i++) {
                        arr_list_task[i].setAttribute("style", "height: " + h + "px")
                    }
                }else{
                    for (var i = 0; i < list_task; i++) {
                        arr_list_task[i].setAttribute("style", "height: 40px")
                    }
                }
            }

        })
    </script>
@endsection
