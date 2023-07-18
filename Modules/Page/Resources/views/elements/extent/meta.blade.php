<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta property="fb:app_id" content="239061346151593" />
<meta name="twitter:site" content="@yobishiken_hana">
<link href="{{ asset('/static/common/images/favicon.ico') }}" rel="icon">
<link href="{{ asset('/static/common/images/favicon.ico') }}" rel="apple-touch-icon">

<title>{{ !empty(config("sys_meta")[request()->route()->getName()]["meta_title"]) ? config("sys_meta")[request()->route()->getName()]["meta_title"] : (@$data['common']["meta_title"] ?? '') }}</title>
<meta property="og:site_name" content="">
<meta property="og:type" content="" />
<meta property="og:image" itemprop="thumbnailUrl" content="{{ isset($data['og_image']) ? $data['og_image'] :  asset('static/common/images/OPG.jpeg') }}"/>
<meta property="og:url" content="">
<meta property="og:title" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["ogp_title"]) ? config("sys_meta")[request()->route()->getName()]["ogp_title"] : (@$data['common']["meta_title"] ?? '')}}">
<meta property="og:description" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["ogp_des"]) ? config("sys_meta")[request()->route()->getName()]["ogp_des"] : '' }}">
<meta name="twitter:image:alt" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["ogp_title"]) ? config("sys_meta")[request()->route()->getName()]["ogp_title"] : (@$data['common']["meta_title"] ?? '') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ request()->url() }}"/>
<meta name="twitter:title" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["ogp_title"]) ? config("sys_meta")[request()->route()->getName()]["ogp_title"] : (@$data['common']["meta_title"] ?? '') }}"/>
<meta name="twitter:image" content="{{ isset($data['og_image']) ? $data['og_image'] :  asset('static/common/images/OPG.jpeg') }}"/>
<meta name="twitter:description" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["ogp_des"]) ? config("sys_meta")[request()->route()->getName()]["ogp_des"] : '' }}"/>
<meta name="description" content="{{ !empty(config("sys_meta")[request()->route()->getName()]["meta_des"]) ? config("sys_meta")[request()->route()->getName()]["meta_des"] : '' }}"/>
