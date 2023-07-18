@extends('user::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                @if(\App\Helpers\Helpers::checkPermissionUser(@\Illuminate\Support\Facades\Auth::guard(config("sys_auth.user"))->user()->project->project_permission_list_for_user, "user.task.edit"))
                <a href="{{ route('user.task.edit',['id' => $data['detail']->id]) }}" class="edit-button">
                    <img src="{{ asset('static/user/images/edit_button.png') }}">
                </a>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label class="title">Chi tiết</label>
                        <div class="content-detail">
                            {!! $data['detail']->details !!}
                        </div>
                    </div>
                </div>
                <div class="list-info">
                    <div class="row">
                        <div class="col-md-5">

                            <div class="item">
                                <span>Loại : </span>
                                <span class="font-bold">{{ @config("sys_common.task_category")[$data['detail']->category_name] ?? '' }}</span>
                            </div>
                            <div class="item">
                                <span>người phụ trách:  </span>
                                <span class="font-bold">{{ !empty($data['detail']->user) ? \App\Helpers\Helpers::renderInfoUser(@$data['detail']->user) : (!empty($data['detail']->userBackup) ? \App\Helpers\Helpers::renderInfoUser(@$data['detail']->userBackup) : "") }}</span>
                            </div>
                            <div class="item">
                                <span>Phiên bản :   </span>
                                <span class="font-bold">{{ $data['detail']->version }}</span>
                            </div>
                            <div class="item">
                                <span>Ngày bắt đầu :   </span>
                                <span class="font-bold">{{ $data['detail']->start_date }}</span>
                            </div>
                            <div class="item">
                                <span>Thời hạn :   </span>
                                <span class="font-bold">{{ $data['detail']->deadline }}</span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="item">
                                <span>Sự ưu tiên : </span>
                                <span class="font-bold">{{ !empty($data['detail']->priority) ? config("sys_common.priority")[$data['detail']->priority] : '' }}</span>
                            </div>
                            <div class="item">
                                <span>Trạng thái :   </span>
                                <span class="font-bold"> &nbsp <a href="#" class="btn-status btn-status-{{ @$data['detail']->statusProject->key_status ?? '' }}">{{ @$data['detail']->statusProject->key_status_name ?? 'default' }}</a></span>
                            </div>
                            <div class="item">
                                <span>Ngày cuối :   </span>
                                <span class="font-bold">{{ $data['detail']->end_date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route("user.task.index") }}">
                @include('form.button.back', ["title" => "戻る", "type" => "button", "id" => ""])
            </a>
        </div>
    </section>
@endsection
