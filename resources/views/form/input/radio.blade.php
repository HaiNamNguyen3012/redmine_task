@php
    /**
    @include('form.input.radio', ["name" => "form1", "id" => "11", "label" => "バックエンド（ウェブ）", "checked" => false, "value" => ""])
    * @name require
    * @id require
    * @label optional
    * @value optional
    * @checked optional (default = false)
    **/
@endphp
<div class="form-group form-input-checkbox">
    <input type="radio" name="{{ !empty($name) ? $name : "" }}" id="{{ !empty($id) ? $id : "" }}" value="{{ !empty($value) ? $value : "" }}" @if(!empty($checked) && $checked == true) checked @endif />
    <label for="{{ !empty($id) ? $id : "" }}">{{ !empty($label) ? $label : "" }}</label>
</div>
