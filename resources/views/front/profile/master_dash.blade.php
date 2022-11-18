@extends('front.include.master_auth')
@section('main_content')
    <div class="container">
        <div class="row d-flex justify-content-around user-dashboard-section">

            <div class="col-lg-3 col-md-3 col-xs-4 dash_menu_right_side d-flex flex-column">

                <div class="col-lg-10 d-flex justify-content-center user-image-profile rounded-2">

                    <div class="col-lg-6 user-avatar d-flex flex-column justify-content-center ">
                        <div class="user-img">
                            @php
                            $user = \Illuminate\Support\Facades\Auth::user();
                            @endphp
                            <img src="{{ $user->image_path ?  asset('images/users/'.$user->image_path)  : asset('images/users/no-image-icon-23494.png') }}"
                                 class="rounded avatar-previewer" alt="">
                        </div>
                        <div class="user-name">
                            <p class="text-center">{{ $user->name }}</p>
                            <p class="text-center">{{ $user->first_name }} {{ $user->last_name }} </p>
                        </div>
                        <div class="d-flex my-2 userAvatarFile justify-content-center">
                            <label for="avatarFile">
                                آپلود عکس
                                <input type="file" class="btn btn-info" name="avatarFile" id="avatarFile">
                            </label>
                        </div>
                    </div>
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

@push('front_custom_scripts')
    <script>
        $('#avatarFile').ijaboCropTool({
            preview : '.avatar-previewer',
            setRatio:1,
            allowedExtensions: ['jpg', 'jpeg','png'],
            buttonsText:['CROP','QUIT'],
            buttonsColor:['#30bf7d','#ee5155', -15],
            processUrl:'{{ route("storeAvatar") }}',
            withCSRF:['_token','{{ csrf_token() }}'],
            onSuccess:function(message, element, status){
                alert(message);
            },
            onError:function(message, element, status){
                alert(message);
            }
        });

    </script>
@endpush
