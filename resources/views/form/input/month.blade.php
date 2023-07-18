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

    <input type="text" @if(!empty($submit) && $submit) onchange="this.form.submit()" @endif name="{{ !empty($name) ? $name : "" }}" class="form-control input-date {{ !empty($class) ? $class : "monthpicker" }}" autocomplete="off" placeholder="yyyy/mm" value="{{ !empty($value) ? $value : "" }}" />

</div>
