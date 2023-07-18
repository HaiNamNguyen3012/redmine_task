@extends('user::layouts.sidebar')

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

                    @include('form.input.text', ["title" =>  "Tên nhiệm vụ", "name" => "name", "place" => "Tên nhiệm vụ", "value" => $data['detail']->name ])
                    @include('form.textarea.text', ["title" =>  "chi tiết", "name" => "details", "place" => "chi tiết", "value" => $data['detail']->details ])

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select', ["title" =>  "Tên danh mục", "name" => "category_name", "place" => "Tên danh mục", $option_arr = $category_task, "value" => $data['detail']->category_name ])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select_custom_background', ["name" => "priority", "title" => "sự ưu tiên", "place" => "sự ưu tiên", $option_arr = config("sys_common.priority"), "value" => $data['detail']->priority  ])
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select', ["title" =>  "người phụ trách", "name" => "user_id", "place" => "", $option_arr = $project_user, "value" => $data['detail']->user_id ])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select_custom_background_status', ["name" => "status", "title" => "trạng thái", "place" => "", "hide_place" => true, $option_arr = $arr_project_status, "value" => $data['detail']->status])
                        </div>
                    </div>
                    @include('form.input.number', ["title" =>  "Version", "name" => "version", "place" => "1.0.0", "value" => $data['detail']->version,"type"=>"number"])
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.input.date', ["title" =>  "ngày bắt đầu", "name" => "start_date", "place" => "yyyy/mm/dd", "value" => $data['detail']->start_date ,"class" => 'start-date-input'])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.input.date', ["title" =>  "ngày kết thúc ", "name" => "end_date", "place" => "yyyy/mm/dd", "value" => $data['detail']->end_date,"class" => 'end-date-input'])
                        </div>
                    </div>
                    @include('form.input.datetime', ["title" =>  "thời hạn", "name" => "deadline", "place" => "yyyy/mm/dd hh:ii:ss", "value" =>$data['detail']->deadline,"class" => 'deadline-date'])
                </div>

                @include('form.button.save', ["title" => "Save", "type" => "submit", "id" => ""])
                <a href="{{ route("user.task.show",['id' => $data['detail']->id]) }}">
                    @include('form.button.back', ["title" => "trở lại", "type" => "button", "id" => ""])
                </a>
            </form>
        </div>
    </section>
@endsection
@section('scripts')
    {!! JsValidator::formRequest('Modules\User\Http\Requests\TaskCreateRequest', '#form') !!}
@endsection
