<footer class="page @if(isset($data['contact'])) footer-contact @endif" >
    <div class="container container-full footer-padd">
        <div class="row">
            <div class="col-md-12 col-padd">
                <div class="menu">
                    <a class="@if(Route::is("page.term.index")) active @endif" href="{{ route('page.term.index') }}"> Ký hiệu dựa trên các điều khoản sử dụng và Đạo luật về các giao dịch thương mại được chỉ định </a>
                    <a class="@if(Route::is("page.policy.index")) active @endif" href="{{ route('page.policy.index') }}">Chính sách bảo mật</a>
                    <a class="@if(Route::is("page.company.index")) active @endif" href="{{ route('page.company.index') }}">Về công ty</a>
                    <a class="@if(Route::is("page.contact*")) active @endif" href="{{ route('page.contact.index') }}">Liên hệ</a>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom">
        © 2023 REGENESIS Inc |  All Rights Reserved.
    </div>
</footer>

