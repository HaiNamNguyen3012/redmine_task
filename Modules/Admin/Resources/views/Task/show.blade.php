@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task padding30">
                <a href="{{ route('admin.task.edit',['id' => $data['detail']->id]) }}" class="edit-button">
                    <img src="{{ asset('static/admin/images/edit_button.png') }}">
                </a>
                <div class="row">
                    <div class="col-md-12">
                        <label class="title">chi tiết</label>
                        <div class="content-detail">
                            {!! $data['detail']->details !!}
                        </div>
                    </div>
                </div>
                <div class="list-info">
                    <div class="row">
                        <div class="col-md-5">

                            <div class="item">
                                <span>Loại: </span>
                                <span class="font-bold">{{ @config("sys_common.task_category")[$data['detail']->category_name] ?? '' }}</span>
                            </div>
                            <div class="item">
                                <span>giám đốc:  </span>
                                <span class="font-bold">{{ !empty($data['detail']->user) ? \App\Helpers\Helpers::renderInfoUser(@$data['detail']->user) : (!empty($data['detail']->userBackup) ? \App\Helpers\Helpers::renderInfoUser(@$data['detail']->userBackup) : "") }}</span>
                            </div>
                            <div class="item">
                                <span>Vesion :   </span>
                                <span class="font-bold">{{ $data['detail']->version }}</span>
                            </div>
                            <div class="item">
                                <span>ngày bắt đầu :   </span>
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
                                <span class="font-bold">{{ !empty($data['detail']->priority) ?  config("sys_common.priority")[$data['detail']->priority] : '' }}</span>
                            </div>
                            <div class="item">
                                <span>Trạng thái :   </span>
                                <span class="font-bold"> &nbsp <a href="#" class="btn-status btn-status-{{ @$data['detail']->statusProject->key_status ?? 'default' }}">
                                        {{ @$data['detail']->statusProject->key_status_name ?? '' }}
                                    </a></span>
                            </div>
                            <div class="item">
                                <span>Ngày kết thúc:   </span>
                                <span class="font-bold">{{ $data['detail']->end_date }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route("admin.task.index") }}">
                @include('form.button.back', ["title" => "戻る", "type" => "button", "id" => ""])
            </a>
        </div>
    </section>
@endsection
