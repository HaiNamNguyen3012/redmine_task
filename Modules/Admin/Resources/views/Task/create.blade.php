@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')

    @php
        $category_task = [];
        foreach (config("sys_common.task_category") as $k => $v){
            if(!empty($project_active) && $project_active->$k){
                $category_task[$k] = $v;
            }
        }
    @endphp

    <section class="wrap-main">
        <div class="container-fluid">
            <form class="" method="post" id="form">
                @csrf
                <div id="wrap-form" class="wrap-form padding30">

                    @if($errors->has('errors'))
                        <div class="alert alert-danger" role="alert">
                            {{$errors->first('errors')}}
                        </div>
                    @endif

                    @include('form.input.text', ["title" =>  "Tên đầu việc", "name" => "name", "place" => "Tên nhiệm vụ", "value" => ""])
                    @include('form.textarea.text', ["title" =>  "Chi tiết", "name" => "details", "place" => "Chi tiết", "value" => ""])

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select', ["title" =>  "Tên đầu mục", "name" => "category_name", "place" => "Tên đầu mục", $option_arr = $category_task, "value" => ""])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select_custom_background', ["name" => "priority", "title" => "Sự ưu tiên", "place" => "Sự ưu tiên", $option_arr = config("sys_common.priority"), "value" => "2"])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select', ["title" =>  "Giám đốc", "name" => "user_id", "place" => "Giám đốc", $option_arr = $project_user, "value" => ""])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select_custom_background_status', ["name" => "status", "title" => "Trạng thái", "place" => "", "hide_place" => true, $option_arr = $arr_project_status, "value" => "unselected"])
                        </div>
                    </div>
                    @include('form.input.number', ["title" =>  "Version", "name" => "version", "place" => "1.0.0", "value" => "","type"=>"number"])
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.input.date', ["title" =>  "Ngày bắt đầu", "name" => "start_date", "place" => "yyyy/mm/dd", "value" => "" ,"class" => 'start-date-input'])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.input.date', ["title" =>  "Ngày kết thúc", "name" => "end_date", "place" => "yyyy/mm/dd", "value" => "","class" => 'end-date-input'])
                        </div>
                    </div>
                    @include('form.input.datetime', ["title" =>  "Thời hạn", "name" => "deadline", "place" => "yyyy/mm/dd hh:ii:ss", "value" => "","class" => 'deadline-date'])
                </div>

                @include('form.button.save', ["title" => "Tạo mới", "type" => "submit", "id" => ""])
                <a href="{{ route("admin.task.index") }}">
                    @include('form.button.back', ["title" => "Trở lại", "type" => "button", "id" => ""])
                </a>
            </form>
        </div>
    </section>
@endsection


@section('scripts')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\TaskCreateRequest', '#form') !!}
@endsection
