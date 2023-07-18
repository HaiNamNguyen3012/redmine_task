@php
    /**
    @include('form.button.plus', ["title" => "", "type" => "button", "id" => ""])
    * @title require
    * @id require
    * @type optional
    **/
@endphp
<div class="form-button">
    <button type="{{ !empty($type) ? $type : "button" }}" @if(!empty($id)) id="{{ $id }}" @endif class="btn">
        <img src="{{ asset("/static/common/images/plus.svg")}}" title="" alt="" />
        {{ !empty($title) ? $title : config("sys_form.button.add") }}
    </button>
</div>
