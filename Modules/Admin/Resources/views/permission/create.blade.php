@extends('admin::layouts.permission')

@section('content')
    <div class="main mt-5 mb-5">
        <form action="" method="post">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tên group quyền</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1"
                                   placeholder="tên quyền">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>key</th>
                                <th>method</th>
                                <th>name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['route']['data'] as $k => $v)
                                <tr>
                                    <td>{{ $k }}</td>
                                    <td>{{ $v['method'] }}</td>
                                    <td>{{ $v['name'] }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="permission_list[]"  type="checkbox" value="{{ $v['name'] }}" id="flexCheckChecked">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection
