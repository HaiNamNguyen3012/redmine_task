@extends('user::layouts.sidebar')
@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
    <section class="wrap-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12 text-end">
                    @if($data["plan_bought"]["is_create_project"])
                        <a href="{{ route('user.project.create') }}" title="Tạo mới">
                            @include('form.button.plus', ["title" => "Tạo mới", "type" => "button", "id" => ""])
                        </a>
                    @else
                        <a href="#" data-bs-toggle="modal"
                           data-bs-target="#exampleModal" title="Tạo mới">
                            @include('form.button.plus', ["title" => "Tạo mới", "type" => "button", "id" => ""])
                        </a>
                    @endif
                </div>
            </div>
            <div class="title-table-form title-table-form-float">
                <p><span class="font-bold">dự án bạn quản lý</span></p>
            </div>

            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table wrap-table table-radius table-responsive">
                            <thead>
                            <tr>
                                <th width="100">lựa chọn</th>
                                <th width="600">tên dự án</th>
                                <th>Ngày tạo ra</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data["list"]["admin"] as $key=>$row)
                                @php
                                    $flag = 0;
                                    if(\App\Helpers\Helpers::checkPermissionUser(@$row->project_permission_list_for_user, "user.project.show")){
                                        $flag = 1;
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        @if(!$key)
                                            @include('form.input.radio', ["name" => "project_actived", "id" => $key."-".md5("admin"), "label" => "", "checked" => (\Illuminate\Support\Facades\Auth::guard(config("sys_auth.user"))->user()->project_actived == $row->id) ? true : false, "value" => $row->id])
                                        @else
                                            @if(!$data["plan_bought"]['is_expire'])
                                                @include('form.input.radio', ["name" => "project_actived", "id" => $key."-".md5("admin"), "label" => "", "checked" => (\Illuminate\Support\Facades\Auth::guard(config("sys_auth.user"))->user()->project_actived == $row->id) ? true : false, "value" => $row->id])
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($flag)
                                            <a href="{{ route('user.project.show',['id' => $row->id]) }}"
                                               class="font-bold font-16">
                                                {{ $row->name }}
                                            </a>
                                        @else
                                            <span class="font-bold font-16">
                                                {{ $row->name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ date("Y/m/d H:i", strtotime($row->created_at)) }} {{ (date("H", strtotime($row->created_at)) > 11) ? "PM" : "AM" }}</td>
                                    <td>
                                        @if($flag)
                                            <a href="{{ route('user.project.show',['id' => $row->id]) }}">
                                                @include('form.button.arrow_right')
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="title-table-form">
                <p><span class="font-bold">dự án tham gia</span></p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table wrap-table table-radius table-responsive">
                            <thead>
                            <tr>
                                <th width="100">lựa chọn</th>
                                <th width="600">Tên dự án</th>
                                <th>Ngày tham gia</th>
                                <th width="100"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data["list"]["member"] as $key=>$row)
                                @php
                                    $flag = 0;
                                    if(\App\Helpers\Helpers::checkPermissionUser(@$row->project_permission_list_for_user, "user.project.show")){
                                        $flag = 1;
                                    }
                                @endphp
                                <tr>
                                    <td>@include('form.input.radio', ["name" => "project_actived", "id" => $key."-".md5("member"), "label" => "", "checked" => (\Illuminate\Support\Facades\Auth::guard(config("sys_auth.user"))->user()->project_actived == $row->id) ? true : false, "value" => $row->id])</td>
                                    <td>
                                        @if($flag)
                                            <a href="{{ route('user.project.show',['id' => $row->id]) }}"
                                               class="font-bold font-16">
                                                {{ $row->name }}
                                            </a>
                                        @else
                                            <span class="font-bold font-16">
                                                {{ $row->name }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ date("Y/m/d H:i", strtotime($row->created_at)) }} {{ (date("H", strtotime($row->created_at)) > 11) ? "PM" : "AM" }}</td>
                                    <td>
                                        @if($flag)
                                            <a href="{{ route('user.project.show',['id' => $row->id]) }}">
                                                @include('form.button.arrow_right')
                                            </a>
                                        @endif
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

    <!-- Button trigger modal -->


    <!-- Modal -->
    @if(!$data["plan_bought"]["is_create_project"])
        <div class="modal fade modal-info" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="box-370">
                            <h2 class="title">
                                kế hoạch miễn phí<br>
                                Bạn có thể tạo tối đa một dự án
                            </h2>
                            <a href="{{ route('user.plan.index') }}" class="btn btn-color-red btn-submit">
                                Nhấn vào đây để thay đổi kế hoạch
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script type="text/javascript">
        $('input[name="project_actived"]').click(function () {
            var active = document.querySelector('input[name="project_actived"]:checked').value;
            var token = $('input[name="_token"]');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                method: "POST",
                url: "{{ route('user.project.active.user') }}",
                data: {project_id: active}
            }).done(function (msg) {
                window.location.reload();
            }).fail(function (err) {

            });
        });

    </script>
@endsection
