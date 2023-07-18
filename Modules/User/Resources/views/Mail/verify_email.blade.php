@if (@$type == 'register')
    <p>Cảm ơn bạn đã sử dụng dịch vụ Simple Gantt.</p>
    <p>Bạn đã tạo thành công tài khoản của mình.</p>
    <p>Nhấp vào URL bên dưới để hoàn tất xác minh tài khoản của bạn.</p>
    <br>
    <a href="{{ @$link }}">Đây</a>
    <br>
    <p>*Nếu bạn không nhận ra email này, vui lòng liên hệ với chúng tôi theo thông tin liên hệ sau.</p>
    <p>*Địa chỉ email này chỉ dùng để gửi. Xin lưu ý rằng chúng tôi sẽ không thể trả lời ngay cả khi bạn trả lời.</p>

    <br>
    <p>【シンプルガント 運営元】</p>
    <p>Công ty TNHH REGENESIS</p>
    <p>Agora Oimachi 3F, 1-6-3 Oi, Shinagawa-ku, Tokyo</p>
@endif

@if (@$type == 're_verify')
    <p style="white-space: pre-wrap">{{ @$user->name ?? @$user->email }} 様</p>

    <p>Cảm ơn bạn đã sử dụng dịch vụ của Oflabo.</p>

    <p>Bạn đã tạo thành công tài khoản của mình.</p>

    <p>Nhấp vào URL bên dưới để hoàn tất xác minh tài khoản của bạn.</p>

    <a href="{{ @$link }}"> こちら</a>
    <br>
    <p>*Nếu bạn không nhận ra email này, vui lòng liên hệ với chúng tôi theo thông tin liên hệ sau.</p>
    <p>*Địa chỉ email này chỉ dùng để gửi. Xin lưu ý rằng chúng tôi sẽ không thể trả lời ngay cả khi bạn trả lời.</p>
    <br>

    <p>【シンプルガント 運営元】</p>
    <p>Công ty TNHH REGENESIS</p>
    <p>Agora Oimachi 3F, 1-6-3 Oi, Shinagawa-ku, Tokyo</p>
@endif
