@php
    /**
    @include('form.select.select_custom_background', ["title" => "バックエンド（ウェブ）", "name" => "form1", "place" => "バックエンド", $option_arr = [1=>"đasa", 2=>"3333"], "value" => "2"])
    * @title require
    * @name require
    * @option_arr require
    * @place optional
    * @value optional
    **/
@endphp
<div class="form-group form-select-custom">
    <label for="{{ !empty($name) ? $name : "" }}">{{ !empty($title) ? $title : "" }}</label>
    <div class="custom-select-status">
        <select class="form-control" name="{{ !empty($name) ? $name : "" }}">
            @if(!empty($hide_place))

            @else
                <option value="0">{{ !empty($place) ? $place : "" }}</option>
            @endif
            @if(!empty($option_arr))
                @foreach($option_arr as $key => $val)
                    <option @if(!empty($value) && $value == $key) selected="selected" @endif data-value="{{ $val['key'] ?? '' }}" value="{{ $key }}">{{ $val['title'] ?? '' }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
