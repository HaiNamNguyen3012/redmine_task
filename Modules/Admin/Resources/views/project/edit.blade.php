@extends('admin::layouts.sidebar')

@section('title-page') {{ !empty($data["common"]["title_seo"]) ? $data["common"]["title_seo"] : config("sys_common.pa")["page_title"] }} @endsection
@section('content')
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
                    @include('form.input.text', ["title" =>  "Tên dự án", "name" => "name", "place" => "Tên dự án", "value" => @$data["detail"]->name])
                    @include('form.textarea.text', ["title" =>  "Chi tiết", "name" => "details", "place" => "Chi tiết", "value" => @$data["detail"]->details])
                    <div class="form-group mb-3">
                        <label for="">Danh sách đầu việc</label>
                    </div>
                    @foreach(config("sys_common.task_category") as $key => $value)
                        @include('form.input.checkbox', ["name" => $key, "id" => $key, "label" => $value, "checked" => (@$data["detail"]->$key ? true :false), "value" => "1"])
                    @endforeach
                </div>

                <div id="wrap-form" class="wrap-form padding30 status-project">
                    <div class="row">
                        <div class="col-md-2 col-sm-4 col-6">
                            <p class="title"><span class="font-bold">trạng thái đầu việc</span></p>

                        </div>

                        <div class="col-md-3 col-sm-4 col-6">
                            <div class="row">
                                <div class="col-md-10 col-sm-10 col-10">
                                    <p class="title text-end">Thứ tự hiển thị trạng thái</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $checkbox_id = "project_ids[]";
                        $checkbox_active = "project_active[]";
                        $checkbox_name = "project_status[]";
                        $checkbox_order = "project_status_order[]";
                        $project_status = !empty($data["detail"]->project_status_list) ? $data["detail"]->project_status_list->toArray() : [];
                        $dem = 0;
                        $dem2 = 0;
                        $pos = 0;
                    @endphp
                    @foreach(config("sys_common.status") as $key => $value)
                        @php
                            $id = !empty($project_status[$dem]["id"]) ? $project_status[$dem]["id"] : "";
                            $active = !empty($project_status[$dem]["is_active"]) ? true : false;
                            $order = !empty($project_status[$dem]["key_status_order"]) ? $project_status[$dem]["key_status_order"] : "";
                            if(!empty($project_status[$dem])) unset($project_status[$dem]);

                            $checkbox_active_id = "project_active_id[".$id."]";
                            $checkbox_name_id = "project_status_id[".$id."]";
                            $checkbox_order_id = "project_status_order_id[".$id."]";
                        @endphp
                        <div class="row row-status">
                            <div class="col-md-2 col-sm-4 col-6">
                                <div class="list-status">
                                    @if(!empty($id))
                                        <input type="hidden" name="{{ $checkbox_id }}" value="{{ $id }}"/>
                                    @endif
                                    <input type="hidden" name="{{ !empty($id) ? $checkbox_name_id : $checkbox_name }}"
                                           value="{{ $value }}"/>
                                    @if($key == "unselected")
                                        <div class="status-first">
                                            <div class="form-group {{ $key }}-checkbox">
                                                <input type="checkbox"
                                                       name="{{ !empty($id) ? $checkbox_active_id : $checkbox_active }}"
                                                       checked="checked"
                                                       id="{{ $key }}" class="project_active_checkbox"
                                                       value="{{ !empty($id) ? $dem : $dem2 }}">
                                                <label for="{{ $key }}">{{ $value }}</label>
                                            </div>
                                        </div>
                                    @else
                                        @include('form.input.checkbox', ["name" => (!empty($id) ? $checkbox_active_id : $checkbox_active), "id" => 'checkbox_'.$key, "label" => $value, "checked" => $active, "value" => (!empty($id) ? $dem : $dem2), "class" => "project_active_checkbox", "onclick" => 'checkValue' ,$data_id = $key ])
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-4 col-6">
                                <div class="list-status-order">
                                    <div class="group-order">
                                        <div class="row">
                                            <div class="col-md-10 col-sm-10 col-10">
                                                @if($key == "unselected")
                                                    @include('form.input.number', ["name" => (!empty($id) ? $checkbox_order_id : $checkbox_order), "id" => $key, "label" => $value, "value" => $order, "onchange" => "checkValue", "onkeyup" => "checkValue", 'class' =>'project_status_order'])
                                                @else
                                                    @include('form.input.number', ["name" => (!empty($id) ? $checkbox_order_id : $checkbox_order), "id" => $key, "label" => $value, "value" => $order, "onchange" => "checkValue", "onkeyup" => "checkValue", 'class' =>'project_status_order'])
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            if(!empty($id)){
                                $dem ++;
                            }else{
                                $dem2 ++;
                            }

                            $pos ++;
                        @endphp
                    @endforeach

                    <div class="status-list-new">
                        @foreach($project_status as $row)
                            @php
                                $id = !empty($project_status[$dem]["id"]) ? $project_status[$dem]["id"] : "";
                                $active = !empty($project_status[$dem]["is_active"]) ? true : false;

                                $checkbox_active_id = "project_active_id[".$id."]";
                                $checkbox_name_id = "project_status_id[".$id."]";
                                $checkbox_order_id = "project_status_order_id[".$id."]";
                            @endphp
                            <div class="row row-status" id="project-add-{{$pos}}">
                                <div class="col-md-2 col-sm-4 col-6">
                                    <div class="list-status">
                                        <input type="hidden" name="{{ $checkbox_id }}" value="{{ $id }}"/>
                                        <input type="hidden" name="{{ $checkbox_name_id }}"
                                               value="{{ $row["key_status_name"] }}">
                                        @include('form.input.checkbox', ["name" => $checkbox_active_id, "id" => $pos, "label" => $row["key_status_name"], "checked" => $active, "value" => $pos, "onclick" => "checkValue", "class" => "project_active_checkbox"])
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="list-status-order">
                                        <div class="group-order">
                                            <div class="row">
                                                <div class="col-md-10 col-sm-10 col-10">
                                                    <div class="form-group form-input">
                                                        <input type="number" name="{{ $checkbox_order_id }}"
                                                               onchange="checkValue(this)" onkeyup="checkValue(this)"
                                                               class="form-control project_status_order" placeholder=""
                                                               value="{{ !empty($row["key_status_order"]) ? $row["key_status_order"] : "" }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 col-sm-2 col-2">
                                                    <div class="hide" onclick="removeStatus({{ $pos }})">
                                                        <img
                                                            src="{{ asset("/static/common/images/hide_status.png") }}"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $dem ++;
                                $pos ++;
                            @endphp
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="status-list">
                                @include('form.input.text', ["title" =>  "", "name" => "status_add",  "place" => "", "value" => "", "custom_error" => true])
                            </div>
                        </div>
                        <div class="plus-empty-bottom text-right">
                            @include('form.button.plus_empty', ["type" => "button", "id" => "add_status"])
                        </div>
                    </div>
                </div>

                <div id="wrap-form" class="wrap-form padding30">
                    <div class="form-group mb-3 permission-list-title" style="display: none;">
                        <label for="">メンバー</label>
                    </div>
                    <div class="form-group permission-list">
                        {{--html--}}
                    </div>
                    <div class="permission-list-input" style="display: none;">
                        {{--html--}}
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            @include('form.input.text', ["title" =>  "メールアドレス", "name" => "per_email", "place" => "", "value" => "", "custom_error" => true])
                        </div>
                        <div class="col-md-6 col-sm-6">
                            @include('form.select.select', ["title" =>  "権限", "name" => "permission_select", "place" => "", $option_arr = $data["permisstion_pluck"], "value" => "", "custom_error" => true])
                        </div>
                    </div>
                    <div class="plus-empty-bottom text-right">
                        @include('form.button.plus_empty', ["type" => "button", "id" => "add_permission"])
                    </div>
                </div>

                @include('form.button.save', ["title" => "Save", "type" => "submit", "id" => "create-btn"])
                <a href="{{ route("admin.project.show", [ 'id' => $data['detail']->id ]) }}">
                    @include('form.button.back', ["title" => "戻る", "type" => "button", "id" => ""])
                </a>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\ProjectCreateRequest', '#form') !!}
    <script src="{{asset('/static/common/js/validate.js')}}"></script>

    <script type="text/javascript">
        var str_empty = "{{ config("sys_common.validation")["empty"] }}";
        var str_empty_select = "{{ config("sys_common.validation")["empty_select"] }}";
        var str_email_error = "{{ config("sys_common.validation")["email_error"] }}";
        var str_permission_email_exits_error = "{{ config("sys_common.validation")["permission_email_exits"] }}";
        var token = $('input[name="_token"]');
    </script>

    <script type="text/javascript">
        var statusListProject = $(".status-list-new");
        var status_add = $('input[name="status_add"]');
        var errorMessageStatusAdd = $("#status_add-error");
        let nameStatus = $("#status_add");

        function removeStatus(e) {
            document.getElementById("project-add-" + e).remove();
            checkAllInput();
        }

        $("#add_status").click(function () {
            let count = document.querySelectorAll('.row-status').length;
            var html_status = '';
            var flag = false;

            var checkbox_active = "project_active[" + count + "]";
            var checkbox_name = "project_status[" + count + "]";
            var checkbox_order = "project_status_order[" + count + "]";

            //check status name
            if (!isExist(status_add.val())) {
                errorMessageStatusAdd.text(str_empty);
                flag = false;
            } else {
                errorMessageStatusAdd.text("");
                flag = true;
            }
            if (!flag) return false;

            html_status += '<div class="row row-status" id="project-add-' + count + '">';
            html_status += '<div class="col-md-2 col-sm-4 col-6">';
            html_status += '<div class="list-status">';
            html_status += '<input type="hidden" name="' + checkbox_name + '" value="' + nameStatus.val() + '" />';
            html_status += '<div class="form-group form-input-checkbox status_1-checkbox">';
            html_status += '<input type="checkbox" data-id="check' + count + '" onclick="checkValue(this)" class="project_active_checkbox" id="project_active_' + count + '" name="' + checkbox_active + '" value="' + count + '" />';
            html_status += '<label for="project_active_' + count + '">' + nameStatus.val() + '</label>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '<div class="col-md-3 col-sm-4 col-6">';
            html_status += '<div class="list-status-order">';
            html_status += '<div class="group-order">';
            html_status += '<div class="row">';
            html_status += '<div class="col-md-10 col-sm-10 col-10">';
            html_status += '<div class="form-group form-input">';
            html_status += '<input type="number" min="0" id="check' + count + '" onkeyup="checkValue(this)" onchange="checkValue(this)" name="' + checkbox_order + '" class="form-control project_status_order" placeholder="" value="" />';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '<div class="col-md-2 col-sm-2 col-2">';
            html_status += '<div class="hide" onclick="removeStatus(' + count + ')">';
            html_status += '<img src="{{ asset("/static/common/images/hide_status.png") }}">';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';
            html_status += '</div>';

            status_add.val('');
            statusListProject.append(html_status);
        });

        checkValue();
        function checkValue(e) {
            let arr_checkbox_lists = [];
            let arr_status_orders = [];
            let checkbox_lists = document.querySelectorAll('input[class="project_active_checkbox"]:checked');
            let status_orders = document.querySelectorAll('.project_status_order');

            let sl = checkbox_lists.length;
            for (var i = 0; i < sl; i++) {
                var val = checkbox_lists[i].value;
                var order = status_orders[val].value;

                arr_checkbox_lists.push(val);
                arr_status_orders.push(order);
            }

            //remove so am
            status_orders.forEach(order => {
                var value = order.value;
                order.value = value.replace(/[^a-z0-9]/gi, '');
            });

            //remove class value-exits
            status_orders.forEach(order => {
                order.classList.remove('value-exits');
            });

            //check trung value
            var flg = true;
            let order_quantity = arr_status_orders.length;
            for (var j = 0; j < order_quantity; j++) {
                var v = arr_checkbox_lists[j];
                for (var k = 0; k < order_quantity; k++) {
                    var val = arr_checkbox_lists[k];
                    if(arr_checkbox_lists.length > 1) {
                        if (status_orders[val].value == "" || status_orders[val].value == null) {
                            status_orders[val].classList.add("value-exits");
                            flg = false;
                        }
                    }
                    if (j != k) {
                        if (status_orders[val].value == status_orders[v].value) {
                            status_orders[val].classList.add("value-exits");
                            flg = false;
                        }
                    }
                }
            }

            if (flg) {
                document.getElementById("create-btn").disabled = false;
            } else {
                document.getElementById("create-btn").disabled = true;
            }
        }
    </script>

    <script type="text/javascript">
        var arr_permission = [];
            //init data per
                @if(!empty($data["detail"]->project_permission_list))
                @foreach($data["detail"]->project_permission_list as $row)
                @if(@$row->user->email == @$data["detail"]->user->email)
            var add_push = ["{{ !empty($row->user->email) ? $row->user->email: "" }}", "{{ $row->permission_id }}", "{{ !empty($data["permisstion_pluck_all"][$row->permission_id]) ? $data["permisstion_pluck_all"][$row->permission_id] : "" }}"];
            arr_permission.push(add_push)
            renderHtml("");
                @endif
                @endforeach
                @endif

                @if(!empty($data["detail"]->project_permission_list))
                @foreach($data["detail"]->project_permission_list as $row)
                @if(@$row->user->email != @$data["detail"]->user->email)
            var add_push = ["{{ !empty($row->user->email) ? $row->user->email: "" }}", "{{ $row->permission_id }}", "{{ !empty($data["permisstion_pluck_all"][$row->permission_id]) ? $data["permisstion_pluck_all"][$row->permission_id] : "" }}"];
            arr_permission.push(add_push)
            renderHtml("");
            @endif
            @endforeach
        @endif

            document.getElementById("per_email").onchange = function () {
                var errorMessageElementEmail = $("#per_email-error");
                var email = $('input[name="per_email"]');

                //check email
                if (!isExist(email.val())) {
                    errorMessageElementEmail.text(str_empty);
                    flag = false;
                } else {
                    errorMessageElementEmail.text("");
                    flag = true;
                }
            }

            document.getElementById("permission_select").onchange = function () {
                var errorMessageElementPermission = $("#permission_select-error");
                var permission = document.getElementById("permission_select");

                //check permission
                if (!isExist(permission.value)) {
                    errorMessageElementPermission.text(str_empty_select);
                    flag = false;
                } else {
                    errorMessageElementPermission.text("");
                    flag = true;
                }
            }

            $("#add_permission").click(function () {
                var errorMessageElementEmail = $("#per_email-error");
                var errorMessageElementPermission = $("#permission_select-error");
                var email = $('input[name="per_email"]');
                var permission = document.getElementById("permission_select");

                var flag = false;

            //check email
            if (!isExist(email.val())) {
                errorMessageElementEmail.text(str_empty);
                flag = false;
            } else {
                errorMessageElementEmail.text("");
                flag = true;
            }
            if (!flag) return false;

            if (isExist(email.val())) {
                if (!isCurrentEmail(email.val())) {
                    errorMessageElementEmail.text(str_email_error);
                    flag = false;
                } else {
                    errorMessageElementEmail.text("");
                    flag = true;
                }
            }
            if (!flag) return false;

            //check permission
            if (!isExist(permission.value)) {
                errorMessageElementPermission.text(str_empty_select);
                flag = false;
            } else {
                errorMessageElementPermission.text("");
                flag = true;
            }
            if (!flag) return false;

            //check exit email
            var fl = true;
            for ($i = 0; $i < arr_permission.length; $i++) {
                if (typeof arr_permission[$i][0] != 'undefined') {
                    if (arr_permission[$i][0] == email.val()) {
                        fl = false;
                        errorMessageElementEmail.text(str_permission_email_exits_error);
                        break;
                    }
                }
            }
            if (!fl) return false;
            errorMessageElementEmail.text("");

            //ajax check email
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token.val()
                },
                method: "POST",
                url: "{{ route('admin.project.check.permission.email') }}",
                data: {email: email.val()}
            }).done(function (msg) {
                var data = msg.response;

                //push data
                var add_push = [email.val(), permission.value, permission.selectedOptions[0].text];
                arr_permission.push(add_push)

                //render html
                renderHtml("");

                    //set null
                    email.val("");

                    var permission_select_default = document.querySelector('#permission_select');
                    permission_select_default[0].selected = true;

            }).fail(function (err) {
                var json = JSON.parse(err.responseText);
                errorMessageElementEmail.text(json.meta.message);
            });
        });

        function renderHtml(a) {
            //remove data
            if (a !== "") {
                for ($i = 0; $i < arr_permission.length; $i++) {
                    if (typeof arr_permission[$i][0] != 'undefined' &&
                        typeof arr_permission[$i][1] != 'undefined' &&
                        typeof arr_permission[$i][2] != 'undefined') {
                        if ($i === a) {
                            arr_permission.splice($i, 1)
                        }
                    }
                }
            }

            var html = '';
            html += '<div class="col-12 col-md-12 col-lg-8 col-xl-6">';
            html += '<div class="wrap-table-small">';
            html += '<table class="table">';
            html += '<tbody>';
            for ($i = 0; $i < arr_permission.length; $i++) {
                if (typeof arr_permission[$i][0] != 'undefined' &&
                    typeof arr_permission[$i][1] != 'undefined' &&
                    typeof arr_permission[$i][2] != 'undefined') {
                    html += '<tr>';
                    html += '<td>' + arr_permission[$i][0] + '</td>';
                    html += '<td>'
                    if (arr_permission[$i][0] !== "{{ @$data["detail"]->user->email }}") {
                        html += arr_permission[$i][2]
                    } else {
                        html += '{{ config("sys_auth.auth_project")["owner"]["name"] }}'
                    }
                    html += '</td>';
                    html += '<td width="30" class="text-right">';
                    if(arr_permission[$i][0] !== "{{ @$data["detail"]->user->email }}") {
                        html += '<div class="form-button-horizontal-arrow">';
                        html += '<button type="button" onclick="renderHtml(' + $i + ');" class="btn button-arrow-horizontal">';
                        html += '<img src="{{ asset("/static/images/arrow_horizontal.png")}}" title="" alt="" />';
                        html += '</button>';
                        html += '</div>';
                    }
                    html += '</td>';
                    html += '</tr>';
                }
            }
            html += '</tbody>';
            html += '</table>';
            html += '</div>';
            html += '</div>';

            //fill data input
            var input_data = '';
            for ($i = 0; $i < arr_permission.length; $i++) {
                if (typeof arr_permission[$i][0] != 'undefined' &&
                    typeof arr_permission[$i][1] != 'undefined' &&
                    typeof arr_permission[$i][2] != 'undefined') {
                    input_data += '<input type="hidden" name="ip_per_email[]" value="' + arr_permission[$i][0] + '" />';
                    input_data += '<input type="hidden" name="ip_per[]" value="' + arr_permission[$i][1] + '" />';
                }
            }

            //fill html
            $(".permission-list").html(html);
            $(".permission-list-input").html(input_data);

            //check data
            if (arr_permission.length > 0) $(".permission-list-title").show(); else $(".permission-list-title").hide();
        }
    </script>
@endsection
