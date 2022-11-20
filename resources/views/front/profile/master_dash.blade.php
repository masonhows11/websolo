@extends('front.include.master_auth')
@section('main_content')
    <div class="container">
        <div class="row row-cols-md-1 row-cols-lg-1 d-flex justify-content-around user-dashboard-section">

            <div class="col-lg-4 col-md-4 col-xs-4 col dash_menu_right_side d-flex flex-column">

                <div class=" d-flex justify-content-center user-image-profile rounded-2">
                    <livewire:user-avatar/>
                </div>

                <div class=" user-profile-menu mt-2 rounded-2">
                    <ul class="mx-4 my-4">
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

            <div class="col-lg-8 col-md-8 col-xs-8 col info_dash_left_side  rounded-2 mt-1 ">
                @yield('info_dash_left_side')
            </div>
        </div>
    </div>
@endsection
