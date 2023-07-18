<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute phải được đồng ý.',
    'active_url' => ':attribute không phải một url hợp lệ.',
    'after' => ':attribute phải là ngày sau :date.',
    'after_or_equal' => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha' => ':attribute có thể chỉ chứa chữ cái.',
    'alpha_dash' => ':attribute có thể chỉ chứa chữ cái, số, gạch ngang và gạch dưới.',
    'alpha_num' => ':attribute có thể chỉ chứa chữ cái và số.',
    'array' => ':attribute phải là mảng.',
    'before' => ':attribute phải là ngày  :date.',
    'before_or_equal' => 'The :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => ':attribute phải nằm giữa :min và :max.',
        'file' => ':attribute phải nằm giữa :min và :max kilobytes.',
        'string' => ':attribute phải nằm giữa :min và :max ký tự.',
        'array' => ':attribute phải nằm giữa :min và :max phần tử.',
    ],
    'boolean' => 'Trường :attribute phải là đúng hoặc sai.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'date' => 'Giá trị :attribute không hợp lệ.',
    'date_equals' => ':attribute phải là một ngày bằng :date.',
    'date_format' => ':attribute phải có kiểu :format.',
    'different' => ':attribute và :other phải khác nhau.',
    'digits' => ':attribute phải có :digits chữ số.',
    'digits_between' => 'The :attribute bao gồm từ :min đến :max chữ số.',
    'dimensions' => ':attribute có kích thước ảnh không hợp lệ.',
    'distinct' => 'Trường :attribute có các phần tử trùng lặp.',
    'email' => ':attribute phải là dạng email hợp lệ.',
    'ends_with' => ':attribute phải kết thúc bằng một trong những giá tị sau: :values.',
    'exists' => 'Giá trị :attribute được chọn không hợp lệ.',
    'file' => ':attribute phải là một file.',
    'filled' => 'Trường :attribute phải có giá trị.',
    'gt' => [
        'numeric' => ':attribute phải lớn hơn :value.',
        'file' => ':attribute phải lớn hơn :value kilobytes.',
        'string' => ':attribute phải lớn hơn :value ký tự.',
        'array' => ':attribute phải có lớn hơn :value phần tử.',
    ],
    'gte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải có nhiều hơn hoặc bằng :value ký tự.',
        'array' => ':attribute phải có :value phần tử hoặc nhiều hơn.',
    ],
    'image' => 'The :attribute must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field does not exist in :other.',
    'integer' => 'The :attribute must be an integer.',
    'ip' => 'The :attribute must be a valid IP address.',
    'ipv4' => ':attribute phải là một địa chỉ IPv4 hợp lệ.',
    'ipv6' => ':attribute phải là một địa chỉ IPv6 hợp lệ.',
    'json' => ':attribute phải là một chuỗi JSON hợp lệ',
    'lt' => [
        'numeric' => ':attribute phải bé hơn :value.',
        'file' => ':attribute phải bé hơn :value kilobytes.',
        'string' => ':attribute phải bé hơn :value ký tự.',
        'array' => ':attribute phải có ít hơn :value phần tử.',
    ],
    'lte' => [
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'file' => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'string' => ':attribute phải có ít hơn hoặc bằng :value ký tự.',
        'array' => ':attribute có không được quá :value items.',
    ],
    'max' => [
        'numeric' => ':attribute có thể không lớn hơn :max.',
        'file' => ':attribute có thể không lớn hơn :max kilobytes.',
        'string' => ':attribute có thể không có nhiều hơn :max ký tự.',
        'array' => ':attribute may not have more than :max items.',
    ],
    'mimes' => ':attribute phải là một file kiểu: :values.',
    'mimetypes' => ':attribute phải là một file kiểu: :values.',
    'min' => [
        'numeric' => ':attribute phải có ít nhất :min.',
        'file' => ':attribute phải có ít nhất :min kilobytes.',
        'string' => 'The :attribute must be at least :min characters.',
        'array' => 'The :attribute must have at least :min items.',
    ],
    'not_in' => ' :attribute được chọn không hợp lệ.',
    'not_regex' => 'Định dạng của :attribute không hợp lệ ',
    'numeric' => ':attribute phải là một số.',
    'password' => 'password không đúng.',
    'present' => 'The :attribute field must be present.',
    'regex' => 'Định dạng của :attribute không hợp lệ.',
    'required' => 'Trường :attribute cần phải điền.',
    'required_if' => 'Trường :attribute cần phải điền khi :other có giá trị là :value.',
    'required_unless' => 'Trường :attribute cần phải điền trừ khi :other ở trong khoảng giá trị :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute and :other must match.',
    'size' => [
        'numeric' => 'The :attribute must be :size.',
        'file' => 'The :attribute must be :size kilobytes.',
        'string' => 'The :attribute must be :size characters.',
        'array' => 'The :attribute must contain :size items.',
    ],
    'starts_with' => ':attribute phải được bắt đầu bằng một trong những giá trị sau : :values.',
    'string' => ':attribute phải là chuỗi ký tự.',
    'timezone' => ':attribute phải là múi giờ hợp lệ.',
    'unique' => ':attribute đã được lấy.',
    'uploaded' => ':attribute tải lên không thành công.',
    'url' => 'Định dạng của :attribute không hợp lệ.',
    'uuid' => ':attribute phải là một UUID hợp lệ.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
