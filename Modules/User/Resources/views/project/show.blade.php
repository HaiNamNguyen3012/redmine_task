@extends('user::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                @if(\App\Helpers\Helpers::checkPermissionUser(@$data['detail']->project_permission_list_for_user, "user.project.edit"))
                    <a href="{{ route('user.project.edit',['id' => $data['detail']->id]) }}" class="edit-button">
                        <img src="{{ asset('static/user/images/edit_button.png') }}">
                    </a>
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <label class="title">chi tiết</label>
                        <div class="content-detail">
                            {!! $data['detail']->details !!}
                        </div>
                    </div>
                </div>
                <div class="list-info-project">
                    <ul>
                        <li>Danh sách đầu việc có thể lựa chọn :</li>
                        <li>
                            @foreach(config("sys_common.task_category") as $key => $value)
                                @if($data['detail']->$key)
                                    <span class="font-bold">{{ $value }}</span>
                                @endif
                            @endforeach
                        </li>
                    </ul>
                    <ul>
                        <li>trạng thái có thể lựa chọn :</li>
                        <li>
                            @php
                                $project_status = !empty($data["detail"]->project_status_active_list) ? $data["detail"]->project_status_active_list : [];
                            @endphp
                            @foreach($project_status as $key => $value)
                                <span class="font-bold">{{ $value->key_status_name }}</span>
                            @endforeach
                        </li>
                    </ul>
                    <ul>
                        <li>người sở hữu:</li>
                        <li>
                            @if(!empty($data["detail"]->project_permission_list))
                                @foreach($data["detail"]->project_permission_list as $row)
                                    @if($row->permission_id == config("sys_auth.auth_project")["admin"]["id"])
                                        @if($data["detail"]->creator == $row->user_id)
                                            <span
                                                class="font-bold">{{ \App\Helpers\Helpers::renderInfoUser(@$row->user) }}</span>
                                        @endif
                                    @endif
                                @endforeach
                            @endif
                        </li>
                    </ul>
                    <ul>
                        <li>thành viên:</li>
                        <li>
                            @if(!empty($data["detail"]->project_permission_list))
                                @foreach($data["detail"]->project_permission_list as $row)
                                    @if($data["detail"]->creator != $row->user_id)
                                        <span
                                            class="font-bold">{{ @$row->user->name ?? $row->user->email }} : {{ !empty($data["permisstion_pluck_all"][$row->permission_id]) ? $data["permisstion_pluck_all"][$row->permission_id] : "" }}</span>
                                    @endif
                                @endforeach
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
            <a href="{{ route("user.project.index") }}">
                @include('form.button.back', ["title" => "戻る", "type" => "button", "id" => ""])
            </a>
        </div>
    </section>
@endsection
