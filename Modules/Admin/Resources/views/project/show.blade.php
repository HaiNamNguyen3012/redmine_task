@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                    <a href="{{ route('admin.project.edit',['id' => $data['detail']->id]) }}" class="edit-button">
                        <img src="{{ asset('static/admin/images/edit_button.png') }}">
                    </a>
                <div class="row">
                    <div class="col-md-12">
                        <label class="title">Chi tiết</label>
                        <div class="content-detail">
                            {!! $data['detail']->details !!}
                        </div>
                    </div>
                </div>
                <div class="list-info-project">
                    <ul>
                        <li>danh sách đầu việc có thể lựa chọn:</li>
                        <li>
                            @foreach(config("sys_common.task_category") as $key => $value)
                                @if($data['detail']->$key)
                                    <span class="font-bold">{{ $value }}</span>
                                @endif
                            @endforeach
                        </li>
                    </ul>
                    <ul>
                        <li>trạng thái có thể lựa chọn:</li>
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
                        <li>オーナー:</li>
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
                        <li>メンバー:</li>
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
            <a href="{{ route("admin.project.index") }}">
                @include('form.button.back', ["title" => "Trở lại", "type" => "button", "id" => ""])
            </a>
        </div>
    </section>
@endsection
