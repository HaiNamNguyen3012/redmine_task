@php
    /**
    @include('form.button.back', ["title" => "", "type" => "button", "id" => ""])
    * @title require
    * @id require
    * @type optional
    **/
@endphp
<div class="form-button">
    <button type="{{ !empty($type) ? $type : "button" }}" @if(!empty($id)) id="{{ $id }}" @endif class="btn button-dark">
        <img src="{{ asset("/static/common/images/back.svg")}}" title="" alt="" />
        {{ !empty($title) ? $title : config("sys_form.button.back") }}
    </button>
</div>
