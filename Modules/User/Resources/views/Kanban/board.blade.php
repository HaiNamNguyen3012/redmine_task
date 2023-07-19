@extends('user::layouts.sidebar')

@section('content')
    @php
        $category_task = [];
        foreach (config("sys_common.task_category") as $k => $v){
            if(!empty($project_active) && $project_active->$k){
                $category_task[$k] = $v;
            }
        }
    @endphp
    <style>
        @if(!$mobile)
        main#main-content {
            padding-top: 30px;
        }

        header#header .wrap-header {
            padding: 0px 30px;
        }
        @endif
    </style>
    <section class="wrap-main">
        <div class="container-fluid">
            <div id="wrap-form" class="wrap-form detail-task search-kanban padding30">
                <div class="row">
                    <form method="get" action="">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="row">
                                <div class="col-md-3 col-sm-4">
                                    <div class="form-group form-select">
                                        <select class="form-select" name="user_id"
                                                aria-label="Default select example">
                                            <option value="">Thành viên</option>
                                            @foreach($project_user_all as $k=>$value)
                                                <option @if(request('user_id') && request('user_id') == $k) selected
                                                        @endif value="{{ $k }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <div class="form-group form-select">
                                        <select class="form-select" name="category_name">
                                            <option value="">Loại</option>
                                            @foreach($category_task as $k=>$value)
                                                <option
                                                    @if(request('category_name') && request('category_name') == $k) selected
                                                    @endif value="{{ $k }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    @include('form.button.search', ["title" => "Lọc", "type" => "submit", "id" => ""])
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="container-kanban">
                @foreach($data["project_status"] as $row)
                    @if($row["is_data"])
                        <div class="list-task" data-status="{{ $row['id'] }}">
                            <div class="head">
                                {{ ($row["key"] == "unselected") ? "Không được chọn/Khác" : $row["title"] }}
                                <span>{{ count($row["task_list"]) }}</span>
                            </div>
                            <div class="draggingContainer">
                                @foreach($row["task_list"] as $task)
                                    <div class="card-task" draggable="true">
                                        <div class="task-info" data-id="{{ $task["id"] }}">
                                            <div class="title"><a
                                                    href="{{ route('user.task.show',['id' => $task["id"]]) }}"
                                                    target="_blank">{{ $task["name"] }} </a>
                                            </div>
                                            <div class="description">
                                                <div class="priority priority-{{ $task['priority'] }}">
                                                    @if(!empty($task['priority']))
                                                        <img
                                                            src="{{ asset('/static/images/'.$task['priority'].'.png') }}">
                                                        {{ !empty($task['priority']) ? config("sys_common.priority")[$task['priority']] : '' }}
                                                    @endif
                                                </div>

                                                <div class="member-name">
                                                    @if(!empty($task["user"]["id"]))
                                                        <span
                                                            class="name">{{ !empty($task["user"]["name"]) ? $task["user"]["name"] : $task["user"]["email"] }}</span>

                                                        <div class="img"
                                                             style="background: {{ @$task["user"]["color"]  ?? '#000' }}">
                                                            {{ \App\Helpers\Helpers::substring($task["user"]["email"],0,2) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('/static/common/drag_drop/css/styles.css')}}">
@endsection

@section('scripts')
    <script src="{{ asset('/static/common/drag_drop/js/script.js') }}"></script>
    <script type="text/javascript">
        function updateTask(task_id) {
            let status_lists = document.querySelectorAll('.list-task');
            var token = $('meta[name="csrf-token"]').attr('content');
            status_lists.forEach((row) => {
                var status_id = row.getAttribute("data-status");

                //task list
                var task_lists = row.querySelectorAll('.card-task');
                task_lists.forEach((task) => {
                    var task_info = task.querySelector(".task-info");
                    var task_id = task_info.getAttribute("data-id");
                    var task_drop = task_info.getAttribute("data-drop");
                    if (task_drop == 1) {
                        task_info.removeAttribute("data-drop");

                        //change status task
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            method: "POST",
                            url: "{{ route('user.task.update.status') }}",
                            data: {status_id: status_id, task_id: task_id}
                        }).done(function (msg) {
                            countTask();
                            var data = msg.response;
                            console.log(data)

                        }).fail(function (err) {

                        });
                    }
                });
            });
        }

        function countTask() {
            let task_lists = document.querySelectorAll('.list-task');
            task_lists.forEach((list) => {
                var head = list.querySelector(".head span");
                var tasks = list.querySelectorAll(".card-task");
                head.innerHTML = tasks.length;
            });
        }
    </script>

    <script>
        var navHeight = document.getElementById('navs').clientHeight;
        var clientHeight = navHeight - 220;
        document.getElementById("container-kanban").style.minHeight = clientHeight + 'px';
    </script>
@endsection
