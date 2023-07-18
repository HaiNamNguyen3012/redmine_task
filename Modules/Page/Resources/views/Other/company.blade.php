@extends('page::layouts.home')
@section('content')

    <div class="banner-page banner-page-company">
        <div class="box-content-banner-index">
            <h1>Hồ sơ công ty</h1>
        </div>
        <img class="img-fluid" src="{{ asset('static/images/banner_company.png') }}"/>
    </div>

    <div id="term-content" class="page-company">
        <div class="container">

            <div class="row">
                <div class="col-md-12 col-padd">
                    <div class="content table-content table-company font-18">

                        <table class="table table-striped">
                            <tr>
                                <td>Tên công ty</td>
                                <td><p class="font-bold">Công ty TNHH REGENESIS</p></td>
                            </tr>

                            <tr>
                                <td>Đại diện</td>
                                <td><p class="font-bold">Naoya Hanai</p></td>
                            </tr>

                            <tr>
                                <td>nội dung kinh doanh</td>
                                <td><p class="font-bold">Phát triển hệ thống, hỗ trợ phát triển hệ thống kinh doanh</p></td>
                            </tr>
                            <tr>
                                <td>cài đặt</td>
                                <td><p class="font-bold">2015/4/2</p></td>
                            </tr>
                            <tr>
                                <td>Cài đặt</td>
                                <td><p class="font-bold">140-0014 Agora Oimachi 3F, 1-6-3 Oi, Shinagawa-ku, Tokyo</p></td>
                            </tr>
                            <tr>
                                <td>Truy cập</td>
                                <td><p class="font-bold">2 phút đi bộ từ ga Oimachi trên Tuyến JR Keihin Tohoku/Rinkai Line/Tokyu Oimachi Line</p></td>
                            </tr>
                            <tr>
                                <td>E-MAIL</td>
                                <td><p class="font-bold">	naoyahanai@regenesis.biz</p></td>
                            </tr>
                            <tr>
                                <td>Trang chủ</td>
                                <td><p class="font-bold">https://regenesis.biz/</p></td>
                            </tr>


                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
