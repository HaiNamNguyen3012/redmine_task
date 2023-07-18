@php
    /**
    @include('form.select.select', ["title" =>  "Text 1", "name" => "form1", "place" => "Abc", $option_arr = [1=>"đasa", 2=>"3333"], "value" => ""])
    * @title require
    * @name require
    * @place require
    * @value optional
    **/
@endphp
<div class="form-group form-select">
    <label for="{{ !empty($name) ? $name : "" }}">{{ !empty($title) ? $title : "" }}</label>
    <select name="{{ !empty($name) ? $name : "" }}" class="form-control" id="{{ !empty($name) ? $name : "" }}" @if(!empty($submit) && $submit) onchange="this.form.submit()" @endif>
        @if(!isset($default))
            <option value="">{{ !empty($place) ? $place : "" }}</option>
        @elseif(!empty($default) && $default)
            <option value="">{{ !empty($place) ? $place : "" }}</option>
        @endif
        @if(!empty($option_arr))
            @foreach($option_arr as $key => $val)
                <option @if(!empty($value) && $value == $key) selected="selected" @endif value="{{ $key }}">{{ $val }}</option>
            @endforeach
        @endif
    </select>
    @if(!empty($custom_error) && $custom_error == true)<span id="{{ !empty($name) ? $name : "" }}-error" class="help-block error-help-block" style="display: inline;"></span>@endif
</div>
