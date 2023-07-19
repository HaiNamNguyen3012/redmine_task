@extends('admin::layouts.sidebar')
@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <form method="get" action="">
        <section class="wrap-main">
            <div class="container-fluid">
                <div class="fill-box">

                    <div class="row">
                        <div class="col-12 col-md-8 col-lg-7 col-xl-6">
                            <div class="row">
                                <div class="col-md-4 col-sm-4">

                                    <select class="form-select" name="user_id" onchange="this.form.submit()"
                                            aria-label="Default select example">
                                        <option value="">Thành viên</option>
                                        @foreach($project_user as $k => $v)
                                            <option @if(request('user_id') && request('user_id') == $k) selected
                                                    @endif value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <select class="form-select" name="category_name" onchange="this.form.submit()">
                                        <option value="">Loại</option>
                                        @foreach(config("sys_common.task_category") as $k => $v)
                                            <option
                                                @if(request('category_name') && request('category_name') == $k) selected
                                                @endif value="{{ $k }}">{{ $v }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <select class="form-select" name="status" onchange="this.form.submit()">
                                        <option value="">Trạng thái</option>
                                        @foreach($arr_project_status as $k => $v)
                                            <option @if(request('status') && request('status') == $k) selected
                                                    @endif value="{{ $k }}">{{ @$v['title'] ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-4 col-lg-5 col-xl-6 text-end">
                            <a href="{{ route('admin.task.create') }}" title="Tạo mới">
                                @include('form.button.plus', ["title" => "Tạo mới", "type" => "button", "id" => ""])
                            </a>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table wrap-table table-radius table-responsive">
                                <thead>
                                <tr>

                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>

                                    <th>Tên nhiệm vụ</th>
                                    <th>Loại</th>
                                    <th>Sự ưu tiên</th>
                                    <th>Người phụ trách</th>
                                    <th>Trạng thái</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['list'] as $k => $v)
                                    @php
                                        $img = '/static/images/'.$v->priority.'.png';
                                    @endphp
                                    <tr>
                                        <td>{{ \App\Helpers\Helpers::formatDateTime('Y/m/d',$v->start_date) }}</td>
                                        <td>{{ \App\Helpers\Helpers::formatDateTime('Y/m/d',$v->end_date) }}</td>
                                        <td>
                                            <a href="{{ route('admin.task.show',['id' => $v->id]) }}"
                                               class="font-bold font-16">{{ $v->name }}</a>
                                        </td>
                                        <td>{{ @config("sys_common.task_category")[$v->category_name] ?? '' }}</td>
                                        <td>
                                            @if(!empty($v->priority))
                                                <div class="priority priority-{{ $v->priority }}">
                                                    <img src="{{ $img }}">
                                                    {{ @config("sys_common.priority")[$v->priority] ?? '' }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ !empty($v->user) ? \App\Helpers\Helpers::renderInfoUser(@$v->user) : (!empty($v->userBackup) ? \App\Helpers\Helpers::renderInfoUser(@$v->userBackup) : "") }}</td>
                                        <td>
                                            <a href="#" class="btn-status btn-status-{{ @$v->statusProject->key_status ?? '' }}">
                                                {{ @$v->statusProject->key_status_name ?? '' }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="pagination-custom">
                        <div class="item text">
                            <span>Page </span>
                        </div>
                        <div class="item pagination-item">
                            {{ $data['list']->appends($_GET)->links('user::components.pagination_custom') }}
                        </div>
                        <div class="item number">
                            <select class="form-control form-control-sm" name="paginate" onchange="this.form.submit()">
                                <option @if(request('paginate') && request('paginate') == 30) selected
                                        @endif value="30">30
                                </option>
                                <option @if(request('paginate') && request('paginate') == 50) selected
                                        @endif value="50">50
                                </option>
                                <option @if(request('paginate') && request('paginate') == 100) selected
                                        @endif value="100">100
                                </option>
                            </select>
                        </div>
                    </div>

                </div>


            </div>
        </section>
    </form>
@endsection
