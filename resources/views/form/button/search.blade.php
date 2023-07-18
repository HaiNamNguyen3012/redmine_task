@php
    /**
    @include('form.button.save', ["title" => "", "type" => "button", "id" => ""])
    * @title require
    * @id require
    * @type optional
    **/
@endphp
<div class="form-button">
    <button type="{{ !empty($type) ? $type : "button" }}" @if(!empty($id)) id="{{ $id }}" @endif class="btn">
        <img src="{{ asset("/static/common/images/search.svg")}}" title="" alt="" />
        {{ !empty($title) ? $title : config("sys_form.button.search") }}
    </button>
</div>
