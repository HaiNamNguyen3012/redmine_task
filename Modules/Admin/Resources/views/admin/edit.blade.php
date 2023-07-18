@extends('admin::layouts.sidebar')

@section('title-page') {{ @$data->name ?? '' }} @endsection
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

                    <div class="form-group form-input">
                        <label for="email">Email</label>
                        <p class="mb-0"><span class="font-bold">{{ @$data->email ?? '' }}</span></p>
                    </div>

                    @include('form.input.text', ["title" =>  "Tên", "name" => "name", "place" => "Tên", "value" => $data->name ])
                </div>
                @include('form.button.save', ["title" => "Save", "type" => "submit", "id" => ""])
            </form>
        </div>
    </section>
@endsection
@section('scripts')
    {!! JsValidator::formRequest('Modules\Admin\Http\Requests\AdminRequest', '#form') !!}
@endsection
