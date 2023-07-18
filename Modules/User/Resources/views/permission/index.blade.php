@extends('user::layouts.permission')

@section('content')
    <div class="main mt-5 mb-5">

        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('user.permission.create') }}" class="btn btn-primary mb-3 btn-sm">create</a>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>permission</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['list'] as $k => $v)
                            @php
                                $per= json_decode($v->permission_list,true);
                            @endphp
                            <tr>
                                <td>{{ $k }}</td>
                                <td>{{ $v->name }}</td>
                                <td>
                                    @foreach($per as $key => $value)
                                        <p class="mb-2">{{ $value }}</p>
                                    @endforeach
                                </td>
                                <td>
                                    <a href="{{ route('user.permission.edit',['id' => $v->id]) }}">edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>

@endsection
