<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

    <ul class="navbar-nav  nav-side  mb-2 mt-3">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('home') }}">خانه</a>
        </li>
        @if(\Illuminate\Support\Facades\Auth::check())
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">پروفایل</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link">خروج</a>
            </li>
        @else
        <li class="nav-item">
            <a href="{{ route('loginForm') }}" class="nav-link">ورود</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('registerForm') }}" class="nav-link">ثبت نام</a>
        </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ route('sampleIndex') }}">نمونه کارها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('articleIndex') }}">مقالات</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('trainingIndex') }} ">آموزش ها</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('aboutUs') }}" >درباره ما</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('contactUs') }}" >ارتباط با ما</a>
        </li>
    </ul>

</div>
