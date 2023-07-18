@extends('admin::layouts.sidebar')
@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 text-end">
                    <a href="{{ route('admin.project.create') }}" title="Tạo mới">
                        @include('form.button.plus', ["title" => "Tạo mới", "type" => "button", "id" => ""])
                    </a>
                </div>
            </div>
            <div class="title-table-form title-table-form-float">
                <p><span class="font-bold">Dự án bạn quản lý</span></p>
            </div>
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table wrap-table table-radius table-responsive">
                            <thead>
                            <tr>
                                <th width="100">Lựa chọn</th>
                                <th width="600">Tên dự án</th>
                                <th>Ngày tạo ra</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data["list"]["admin"] as $key=>$row)
                                <tr>
                                    <td>@include('form.input.radio', ["name" => "project_admin_actived", "id" => $key."-".md5("admin"), "label" => "", "checked" => (@$user_choose->project_admin_actived == $row->id) ? true : false, "value" => $row->id])</td>
                                    <td>
                                        <a href="{{ route('admin.project.show',['id' => $row->id]) }}" class="font-bold font-16">
                                            {{ $row->name }}
                                        </a>
                                    </td>
                                    <td>{{ date("Y/m/d H:i", strtotime($row->created_at)) }} {{ (date("H", strtotime($row->created_at)) > 11) ? "PM" : "AM" }}</td>
                                    <td>
                                        <a href="{{ route('admin.project.show',['id' => $row->id]) }}">
                                            @include('form.button.arrow_right')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="title-table-form">
                <p><span class="font-bold">参加しているプロジェクト</span></p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table wrap-table table-radius table-responsive">
                            <thead>
                            <tr>
                                <th width="100">選択中</th>
                                <th width="600">プロジェクト名</th>
                                <th>作成日</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data["list"]["member"] as $key=>$row)
                                <tr>
                                    <td>@include('form.input.radio', ["name" => "project_admin_actived", "id" => $key."-".md5("member"), "label" => "", "checked" => (@$user_choose->project_admin_actived == $row->id) ? true : false, "value" => $row->id])</td>
                                    <td>
                                        <a href="{{ route('admin.project.show',['id' => $row->id]) }}"
                                           class="font-bold font-16">
                                            {{ $row->name }}
                                        </a>
                                    </td>
                                    <td>{{ date("Y/m/d H:i", strtotime($row->created_at)) }} {{ (date("H", strtotime($row->created_at)) > 11) ? "PM" : "AM" }}</td>
                                    <td>
                                        <a href="{{ route('admin.project.show',['id' => $row->id]) }}">
                                            @include('form.button.arrow_right')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @csrf
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('input[name="project_admin_actived"]').click(function () {
            var active = document.querySelector('input[name="project_admin_actived"]:checked').value;
            var token = $('input[name="_token"]');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                method: "POST",
                url: "{{ route('admin.project.active.user') }}",
                data: {project_id: active}
            }).done(function (msg) {
                window.location.reload();
            }).fail(function (err) {

            });
        });

    </script>
@endsection
