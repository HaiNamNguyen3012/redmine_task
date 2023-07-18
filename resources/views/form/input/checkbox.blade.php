@php
    /**
    @include('form.input.checkbox', ["name" => "form1", "id" => "11", "label" => "バックエンド（ウェブ）", "checked" => false, "value" => ""])
    * @name require
    * @id require
    * @label optional
    * @value optional
    * @checked optional (default = false)
    **/
@endphp
<div class="form-group form-input-checkbox {{ !empty($class) ? $class : "" }}-checkbox">
    <input type="checkbox" {{ !empty($disabled) ? $disabled : "" }} class="{{ !empty($class) ? $class : "" }}" data-id="{{ !empty($data_id) ? $data_id : "" }}"  @if(!empty($onclick))  onclick="{{ $onclick }}(this)" @endif name="{{ !empty($name) ? $name : "" }}" id="{{ !empty($id) ? $id : "" }}" value="{{ !empty($value) ? $value : "" }}" @if(!empty($checked) && $checked == true) checked @endif />
    <label for="{{ !empty($id) ? $id : "" }}">{{ !empty($label) ? $label : "" }}</label>
</div>
