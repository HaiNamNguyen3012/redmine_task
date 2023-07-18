@php
    /**
    @include('form.input.text', ["title" =>  "Text 1", "name" => "form1", "place" => "Abc", "value" => ""])
    * @title require
    * @name require
    * @place optional
    * @value optional
    **/
@endphp
<div class="form-group form-input">
    <label for="{{ !empty($name) ? $name : "" }}">{{ !empty($title) ? $title : "" }}</label>
    <input type="text" name="{{ !empty($name) ? $name : "" }}" class="form-control" id="{{ !empty($name) ? $name : "" }}" placeholder="{{ !empty($place) ? $place : "" }}" value="{{ !empty($value) ? $value : "" }}" />
    @if(!empty($custom_error) && $custom_error == true)<span id="{{ !empty($name) ? $name : "" }}-error" class="help-block error-help-block" style="display: inline;"></span>@endif
</div>
