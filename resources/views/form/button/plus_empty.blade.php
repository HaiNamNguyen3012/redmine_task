@php
    /**
    @include('form.button.plus_empty', ["type" => "button", "id" => ""])
    * @id require
    * @type optional
    **/
@endphp
<div class="form-button">
    <button type="{{ !empty($type) ? $type : "button" }}" @if(!empty($id)) id="{{ $id }}" @endif class="btn button-empty">
        <img src="{{ asset("/static/common/images/plus.svg")}}" title="" alt="" />
    </button>
</div>
