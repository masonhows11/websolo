@extends('front.include.master_auth')
@section('main_content')
    <div class="container">
        <div class="row d-flex justify-content-around user-dashboard-section">

            <div class="col-lg-3 col-md-3 col-xs-4 dash_menu_right_side d-flex flex-column">

                <div class="col-lg-10 d-flex justify-content-center user-image-profile rounded-2">

                    <livewire:user-avatar/>

                </div>

                <div class="col-lg-10 user-profile-menu mt-4 rounded-2">
                    <ul class="mx-2 my-3">
                        <li class=""><i class="fa fa-home-user me-3"></i><a href="{{ route('dashboard') }}">اطلاعات کاربری</a></li>
                        <li class=""><i class="far fa-heart me-3"></i><a href="#">لیست علاقه مندی ها</a></li>
                        <li class=""><i class="far fa-message me-3"></i><a href="#">پیغام ها</a></li>
                        <li class=""><i class="fa fa-history me-3"></i><a href="#">بازدید های اخیر</a></li>
                        <li class=""><i class="fa fa-info-circle me-3"></i><a href="{{ route('editProfile') }}">ویرایش اطلاعات کاربری</a></li>
                        <li class=""><i class="fa fa-envelope me-3"></i><a href="{{ route('editEmailForm') }}">ویرایش  آدرس ایمیل</a></li>
                        <li class=""><i class="fa fa-sign-out me-3"></i><a href="{{ route('logout') }}">خروج</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 col-md-6 col-xs-6 info_dash_left_side  rounded-2 my-4">
                @yield('info_dash_left_side')
            </div>
        </div>
    </div>
@endsection
