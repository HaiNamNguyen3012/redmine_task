@php
    /**
    @include('form.input.date', ["title" =>  "Text 1", "name" => "form1", "value" => ""])
    * @title require
    * @name require
    * @value require
    **/
@endphp
<div class="form-group form-input form-date">
    <label for="{{ !empty($name) ? $name : "" }}">{{ !empty($title) ? $title : "" }}</label>
    <input type="text" name="{{ !empty($name) ? $name : "" }}" class="form-control input-date {{ !empty($class) ? $class : "date-picker-two" }}" autocomplete="off" placeholder="yyyy/mm/dd" value="{{ !empty($value) ? $value : "" }}" />
</div>
