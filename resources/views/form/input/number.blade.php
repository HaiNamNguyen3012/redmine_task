@php
    /**
    @include('form.input.number', ["title" =>  "Text 1", "name" => "form1", "place" => "Abc", "value" => ""])
    * @title require
    * @name require
    * @place optional
    * @value optional
    **/
@endphp
<div class="form-group form-input">
    <label for="{{ !empty($id) ? $id : (!empty($name) ? $name : "") }}">{{ !empty($title) ? $title : "" }}</label>
    <input min="0" type="number" name="{{ !empty($name) ? $name : "" }}" @if(isset($onchange)) onchange="{{$onchange}}(this)" @endif @if(isset($onkeyup)) onkeyup="{{$onkeyup}}(this)" @endif class="form-control {{ !empty($class) ? $class : "" }}" id="{{ !empty($id) ? $id : (!empty($name) ? $name : "") }}" placeholder="{{ !empty($place) ? $place : "" }}" value="{{ !empty($value) ? $value : "" }}" />
</div>
