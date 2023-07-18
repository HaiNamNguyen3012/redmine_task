@php
    /**
    @include('form.textarea.text', ["title" =>  "Text 1", "name" => "form1", "place" => "Abc", "value" => ""])
    * @title require
    * @name require
    * @place optional
    * @value optional
    **/
@endphp
<div class="form-group form-textarea">
    <label for="{{ !empty($name) ? $name : "" }}">{{ !empty($title) ? $title : "" }}</label>
    <textarea name="{{ !empty($name) ? $name : "" }}" class="form-control" id="{{ !empty($name) ? $name : "" }}" rows="5" placeholder="{{ !empty($place) ? $place : "" }}">{{ !empty($value) ? $value : "" }}</textarea>
</div>
