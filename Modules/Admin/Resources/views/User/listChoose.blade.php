@extends('admin::layouts.no-sidebar')

@section('content')
    @php
        $d_content = true;
    @endphp
    <div class="wrap-user-choose">
        <div id="main-choose" class="main-choose">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table wrap-table table-radius table-responsive">
                                <thead>
                                <tr>
                                    <th style="padding: 20px 15px;">Tên</th>
                                    <th style="padding: 20px 15px;" width="30"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data["list"] as $row)
                                    <tr style="background: #fff;">
                                        <td style="padding: 15px 15px;">
                                            <div class="font-bold pt-2 font-16">{{ @$row->name ?? $row->email }}</div>
                                        </td>
                                        <td style="padding: 15px 15px;">
                                            <a href="{{ route('admin.user.choose',['id' => $row->id]) }}">
                                                @include('form.button.arrow_right')
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="logout-user-list">
            <a href="{{ route('admin.logout') }}">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M1.5 8.75C1.5 6.43843 2.3226 4.64078 3.60904 3.41877C4.90142 2.19112 6.70939 1.5 8.75 1.5C9.16421 1.5 9.5 1.16421 9.5 0.75C9.5 0.335786 9.16421 0 8.75 0C6.37061 0 4.17858 0.808876 2.57596 2.33123C0.967398 3.85922 0 6.06157 0 8.75C0 11.4384 0.967398 13.6408 2.57596 15.1688C4.17858 16.6911 6.37061 17.5 8.75 17.5C9.16421 17.5 9.5 17.1642 9.5 16.75C9.5 16.3358 9.16421 16 8.75 16C6.70939 16 4.90142 15.3089 3.60904 14.0812C2.3226 12.8592 1.5 11.0616 1.5 8.75Z"
                        fill="#2B313D"/>
                    <path
                        d="M13.8997 5.71967C14.1926 5.42678 14.6674 5.42678 14.9603 5.71967L17.5203 8.27967C17.8132 8.57256 17.8132 9.04744 17.5203 9.34033L14.9603 11.9003C14.6674 12.1932 14.1926 12.1932 13.8997 11.9003C13.6068 11.6074 13.6068 11.1326 13.8997 10.8397L15.1798 9.55957H6.75C6.33579 9.55957 6 9.22378 6 8.80957C6 8.39536 6.33579 8.05957 6.75 8.05957H15.1789L13.8997 6.78033C13.6068 6.48744 13.6068 6.01256 13.8997 5.71967Z"
                        fill="#2B313D"/>
                </svg>

                Log out
            </a>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        let height = document.getElementById('main-choose').clientHeight;
        if(height > 800){
            $(".logout-user-list").addClass('fix_bottom');
        }
    </script>
@endsection
